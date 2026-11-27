<?php

namespace App\Exports;

use App\Models\AccesoriosEquipo;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventarioCompletoSheet implements FromCollection, WithEvents, WithStyles, WithColumnWidths, WithTitle
{
    protected Collection $equipos;

    public function __construct(Collection $equipos)
    {
        $this->equipos = $equipos;
    }

    public function title(): string
    {
        return 'INVENTARIO COMPLETO';
    }

    public function collection()
    {
        $filas = collect();

        // Espacio suficiente para encabezado + resumen
        for ($i = 1; $i <= 10; $i++) {
            $filas->push(array_fill(0, 16, ''));
        }

        $indice = 1;

        // ========== EQUIPOS + ACCESORIOS RELACIONADOS ==========
        foreach ($this->equipos as $equipo) {
            $tipo     = strtoupper($equipo->tipoEquipo->nombre ?? '-');
            $serie    = strtoupper($equipo->num_serie ?? '-');
            $marca    = strtoupper($equipo->marca ?? '-');
            $modelo   = strtoupper($equipo->modelo ?? '-');

            $procesador = '';
            $ram = '';
            $disco = '';
            $color = '';
            $descripcion = '';

            if ($equipo->especificacionesLaptops) {
                $procesador = strtoupper($equipo->especificacionesLaptops->procesador ?? '');
                $ram        = strtoupper($equipo->especificacionesLaptops->ram ?? '');
                $disco      = strtoupper($equipo->especificacionesLaptops->disco_duro ?? '');
                $color      = strtoupper($equipo->especificacionesLaptops->color ?? '');
            } elseif ($equipo->especificacionesEquipo) {
                $color      = strtoupper($equipo->especificacionesEquipo->color ?? '');
                $descripcion = strtoupper($equipo->especificacionesEquipo->descripcion ?? '');
            }

            $estado = strtoupper(
                $equipo->especificacionesLaptops->estado
                    ?? $equipo->especificacionesEquipo->estado
                    ?? '-'
            );

            $ubicacion = strtoupper($equipo->ubicacione->nombre ?? '-');

            $observacion = strtoupper(
                $equipo->especificacionesLaptops->observaciones
                    ?? $equipo->especificacionesEquipo->observaciones
                    ?? $equipo->observacion
                    ?? '-'
            );

            $detalles = [];
            if ($procesador !== '') $detalles[] = 'PROCESADOR: ' . $procesador;
            if ($ram !== '')        $detalles[] = 'RAM: ' . $ram;
            if ($disco !== '')      $detalles[] = 'DISCO DURO: ' . $disco;
            if ($descripcion !== '') $detalles[] = 'DESCRIPCIÓN: ' . $descripcion;

            $detallesTexto = !empty($detalles) ? implode("\n", $detalles) : '-';

            $accesorios = $equipo->accesoriosEquipos ?? collect();

            if ($accesorios->isEmpty()) {
                $filas->push([
                    $indice,
                    $tipo, $serie, $marca, $modelo, $estado, $ubicacion,
                    $equipo->fecha_registro ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d/m/Y') : '-',
                    $observacion, $detallesTexto, $color ?: '-',
                    '-', '-', '-', '-', '-'
                ]);
            } else {
                foreach ($accesorios as $accesorio) {
                    $filas->push([
                        $indice,
                        $tipo, $serie, $marca, $modelo, $estado, $ubicacion,
                        $equipo->fecha_registro ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d/m/Y') : '-',
                        $observacion, $detallesTexto, $color ?: '-',
                        strtoupper($accesorio->tipo ?? '-'),
                        strtoupper($accesorio->marca ?? '-'),
                        strtoupper($accesorio->num_serie ?? '-'),
                        strtoupper($accesorio->estado ?? '-'),
                        strtoupper($accesorio->observaciones ?? '-'),
                    ]);
                }
            }

            $indice++;
        }

        // ========== ACCESORIOS INDEPENDIENTES (al final) ==========
        $ubicacionIds = $this->equipos->pluck('ubicacion_id')->filter()->unique()->values();

        $query = AccesoriosEquipo::query()
            ->whereNull('equipo_id')
            ->with('ubicacion');

        if ($ubicacionIds->isNotEmpty()) {
            $query->whereIn('ubicacion_id', $ubicacionIds);
        }

        $accesoriosIndependientes = $query->orderBy('tipo')->orderBy('marca')->get();

        foreach ($accesoriosIndependientes as $accesorio) {
            $filas->push([
                $indice,
                'SIN EQUIPO', '-', '-', '-', '-',
                strtoupper($accesorio->ubicacion->nombre ?? 'SIN UBICACIÓN'),
                '-', '-', '-', '-',
                strtoupper($accesorio->tipo ?? '-'),
                strtoupper($accesorio->marca ?? '-'),
                strtoupper($accesorio->num_serie ?? '-'),
                strtoupper($accesorio->estado ?? '-'),
                strtoupper($accesorio->observaciones ?? '-'),
            ]);
            $indice++;
        }

        return $filas;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,  'B' => 18, 'C' => 20, 'D' => 18, 'E' => 18,
            'F' => 14, 'G' => 22, 'H' => 21, 'I' => 32, 'J' => 36,
            'K' => 15, 'L' => 18, 'M' => 18, 'N' => 23, 'O' => 14,
            'P' => 38,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // ========== TÍTULO ==========
                $sheet->mergeCells('A1:P1');
                $sheet->setCellValue('A1', 'FORMATO PARA REGISTRO DE EQUIPOS TECNOLOGICOS');
                $sheet->getStyle('A1:P1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(22);

                // ========== ENCABEZADO RESPONSABLE / UBICACIÓN ==========
                $ubicaciones = $this->equipos
                    ->map(fn ($e) => mb_strtoupper(trim($e->ubicacione->nombre ?? '')))
                    ->filter()
                    ->unique();

                $ubicacionReporte = $ubicaciones->count() === 1
                    ? $ubicaciones->first()
                    : ($ubicaciones->count() ? 'VARIAS' : '-');

                $fechaReporte = now()->format('d-m-Y');

                $sheet->setCellValue('B2', 'RESPONSABLE');
                $sheet->mergeCells('C2:E2');
                $sheet->setCellValue('C2', 'ING. MICHAEL CABOS OLIVARES');
                $sheet->setCellValue('G2', 'UBICACIÓN');
                $sheet->mergeCells('H2:I2');
                $sheet->setCellValue('H2', $ubicacionReporte);

                $sheet->setCellValue('B3', 'CARGO');
                $sheet->mergeCells('C3:E3');
                $sheet->setCellValue('C3', 'COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO');
                $sheet->setCellValue('G3', 'FECHA');
                $sheet->mergeCells('H3:I3');
                $sheet->setCellValue('H3', $fechaReporte);

                foreach (['B2:E2', 'G2:I2', 'B3:E3', 'G3:I3'] as $rango) {
                    $sheet->getStyle($rango)->applyFromArray([
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);
                }

                foreach (['B2', 'G2', 'B3', 'G3'] as $celda) {
                    $sheet->getStyle($celda)->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFD6A84F'],
                        ],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                }

                $sheet->getRowDimension(2)->setRowHeight(18);
                $sheet->getRowDimension(3)->setRowHeight(18);
                $sheet->getRowDimension(4)->setRowHeight(10); // separación

                // ========== RESUMEN ==========
                $totalEquipos = $this->equipos->count();

                $equiposConAccesorio = $this->equipos->filter(function ($equipo) {
                    return ($equipo->accesoriosEquipos ?? collect())->isNotEmpty();
                })->count();

                $equiposSinAccesorio = $totalEquipos - $equiposConAccesorio;

                $totalAccesoriosRelacionados = $this->equipos->sum(function ($equipo) {
                    return ($equipo->accesoriosEquipos ?? collect())->count();
                });

                $ubicacionIds = $this->equipos->pluck('ubicacion_id')->filter()->unique()->values();

                $queryIndependientes = AccesoriosEquipo::query()->whereNull('equipo_id');
                if ($ubicacionIds->isNotEmpty()) {
                    $queryIndependientes->whereIn('ubicacion_id', $ubicacionIds);
                }
                $totalAccesoriosSinEquipo = $queryIndependientes->count();

                $totalAccesorios = $totalAccesoriosRelacionados + $totalAccesoriosSinEquipo;

                $sheet->setCellValue('B5', 'TOTAL EQUIPOS');
                $sheet->setCellValue('C5', $totalEquipos);
                $sheet->setCellValue('E5', 'TOTAL ACCESORIOS');
                $sheet->setCellValue('F5', $totalAccesorios);

                $sheet->setCellValue('B6', 'EQUIPOS CON ACCESORIO');
                $sheet->setCellValue('C6', $equiposConAccesorio);
                $sheet->setCellValue('E6', 'ACCESORIOS SIN EQUIPO');
                $sheet->setCellValue('F6', $totalAccesoriosSinEquipo);

                $sheet->setCellValue('H5', 'EQUIPOS SIN ACCESORIOS');
                $sheet->setCellValue('I5', $equiposSinAccesorio);
                $sheet->setCellValue('H6', 'ACCESORIOS RELACIONADOS');
                $sheet->setCellValue('I6', $totalAccesoriosRelacionados);

                foreach (['B5', 'E5', 'B6', 'E6', 'H5', 'H6'] as $celda) {
                    $sheet->getStyle($celda)->applyFromArray([
                        'font' => ['bold' => true, 'size' => 9],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFD6A84F'],
                        ],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    ]);
                }

                foreach (['C5', 'F5', 'C6', 'F6', 'I5', 'I6'] as $celda) {
                    $sheet->getStyle($celda)->applyFromArray([
                        'font' => ['bold' => true, 'size' => 10],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    ]);
                }

                $sheet->getRowDimension(5)->setRowHeight(18);
                $sheet->getRowDimension(6)->setRowHeight(18);
                $sheet->getRowDimension(7)->setRowHeight(10); // separación antes de tabla

                // ========== SUBTÍTULO ==========
                $sheet->mergeCells('A8:P8');
                $sheet->setCellValue('A8', 'INVENTARIO COMPLETO (EQUIPOS + ACCESORIOS INDEPENDIENTES)');
                $sheet->getStyle('A8:P8')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // ========== AGRUPACIÓN DE COLUMNAS ==========
                $sheet->mergeCells('B9:I9');
                $sheet->mergeCells('J9:K9');
                $sheet->mergeCells('L9:P9');
                $sheet->setCellValue('B9', 'INFORMACIÓN DEL EQUIPO');
                $sheet->setCellValue('J9', 'DETALLES');
                $sheet->setCellValue('L9', 'ACCESORIO');
                $sheet->setCellValue('A9', 'N°');

                $sheet->getStyle('A9:P9')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFD6A84F'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                // ========== ENCABEZADOS DE COLUMNAS ==========
                $headers = [
                    'A10' => 'N°',
                    'B10' => 'TIPO',
                    'C10' => 'NÚM. SERIE',
                    'D10' => 'MARCA',
                    'E10' => 'MODELO',
                    'F10' => 'ESTADO',
                    'G10' => 'UBICACIÓN',
                    'H10' => 'FECHA REGISTRO',
                    'I10' => 'OBSERVACIONES',
                    'J10' => 'DETALLES',
                    'K10' => 'COLOR',
                    'L10' => 'TIPO ACCESORIO',
                    'M10' => 'MARCA',
                    'N10' => 'SERIE',
                    'O10' => 'ESTADO',
                    'P10' => 'OBSERVACIONES',
                ];

                foreach ($headers as $celda => $valor) {
                    $sheet->setCellValue($celda, $valor);
                }

                $sheet->getStyle('A10:P10')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 9],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF90EE90'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
                $sheet->getRowDimension(10)->setRowHeight(28);

                // ========== ESTILO DE DATOS + AJUSTE DE ALTURA ==========
                $highestRow = $sheet->getHighestRow();
                if ($highestRow >= 11) {
                    $sheet->getStyle('A11:P' . $highestRow)->applyFromArray([
                        'font' => ['size' => 9],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true,
                        ],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    ]);

                    // Color columnas J y K (DETALLES)
                    $sheet->getStyle('J11:K' . $highestRow)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFF2F2F2'],
                        ],
                    ]);

                    // Color columnas L a P (ACCESORIO)
                    $sheet->getStyle('L11:P' . $highestRow)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFDDE8F3'],
                        ],
                    ]);

                    $sheet->getStyle('A11:A' . $highestRow)->getNumberFormat()->setFormatCode('00');
                    $sheet->getStyle('I11:I' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('J11:J' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('P11:P' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                    $sheet->getStyle('A11:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('F11:H' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('O11:O' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    for ($fila = 11; $fila <= $highestRow; $fila++) {
                        $maxLineas = 1;
                        foreach (range('A', 'P') as $col) {
                            $valor = $sheet->getCell($col . $fila)->getValue();
                            if ($valor !== null) {
                                $lineas = substr_count((string) $valor, "\n") + 1;
                                $maxLineas = max($maxLineas, $lineas);
                            }
                        }
                        $sheet->getRowDimension($fila)->setRowHeight(max(22, $maxLineas * 15));
                    }

                    $sheet->setAutoFilter('A10:P' . $highestRow);
                }
            },
        ];
    }
}