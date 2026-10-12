<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EquiposCompletoSheet implements FromCollection, WithEvents, WithStyles, WithColumnWidths
{
    protected Collection $equipos;

    public function __construct(Collection $equipos)
    {
        $this->equipos = $equipos;
    }

    public function collection()
    {
        $filas = collect();

        for ($i = 1; $i <= 7; $i++) {
            $filas->push(array_fill(0, 16, ''));
        }

        $indice = 1;

        foreach ($this->equipos as $equipo) {
            $tipo = strtoupper($equipo->tipoEquipo->nombre ?? '-');
            $serie = strtoupper($equipo->num_serie ?? '-');
            $marca = strtoupper($equipo->marca ?? '-');
            $modelo = strtoupper($equipo->modelo ?? '-');

            $procesador = '';
            $ram = '';
            $disco = '';
            $color = '';
            $descripcion = '';

            if ($equipo->especificacionesLaptops) {
                $procesador = strtoupper($equipo->especificacionesLaptops->procesador ?? '');
                $ram = strtoupper($equipo->especificacionesLaptops->ram ?? '');
                $disco = strtoupper($equipo->especificacionesLaptops->disco_duro ?? '');
                $color = strtoupper($equipo->especificacionesLaptops->color ?? '');
            } elseif ($equipo->especificacionesEquipo) {
                $color = strtoupper($equipo->especificacionesEquipo->color ?? '');
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

            if ($procesador !== '') {
                $detalles[] = 'PROCESADOR: ' . $procesador;
            }
            if ($ram !== '') {
                $detalles[] = 'RAM: ' . $ram;
            }
            if ($disco !== '') {
                $detalles[] = 'DISCO DURO: ' . $disco;
            }
            if ($descripcion !== '') {
                $detalles[] = 'DESCRIPCIÓN: ' . $descripcion;
            }

            $detallesTexto = !empty($detalles) ? implode("\n", $detalles) : '-';

            $tiposAccesorios = [];
            $marcasAccesorios = [];
            $seriesAccesorios = [];
            $estadosAccesorios = [];
            $observacionesAccesorios = [];

            foreach ($equipo->accesoriosEquipos ?? [] as $accesorio) {
                $tiposAccesorios[] = strtoupper($accesorio->tipo ?? '-');
                $marcasAccesorios[] = strtoupper($accesorio->marca ?? '-');
                $seriesAccesorios[] = strtoupper($accesorio->num_serie ?? '-');
                $estadosAccesorios[] = strtoupper($accesorio->estado ?? '-');
                $observacionesAccesorios[] = strtoupper($accesorio->observaciones ?? '-');
            }

            $filas->push([
                sprintf('%02d', $indice),
                $tipo,
                $serie,
                $marca,
                $modelo,
                $estado,
                $ubicacion,
                $equipo->fecha_registro
                    ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d/m/Y')
                    : '-',
                $observacion,
                $detallesTexto,
                $color ?: '-',
                !empty($tiposAccesorios) ? implode("\n", $tiposAccesorios) : '-',
                !empty($marcasAccesorios) ? implode("\n", $marcasAccesorios) : '-',
                !empty($seriesAccesorios) ? implode("\n", $seriesAccesorios) : '-',
                !empty($estadosAccesorios) ? implode("\n", $estadosAccesorios) : '-',
                !empty($observacionesAccesorios) ? implode("\n", $observacionesAccesorios) : '-',
            ]);

            $indice++;
        }

        return $filas;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 18,
            'C' => 20,
            'D' => 18,
            'E' => 18,
            'F' => 14,
            'G' => 20,
            'H' => 15,
            'I' => 30,
            'J' => 35,
            'K' => 15,
            'L' => 18,
            'M' => 18,
            'N' => 20,
            'O' => 14,
            'P' => 30,
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

                $ubicaciones = $this->equipos
                    ->map(fn ($equipo) => mb_strtoupper(trim($equipo->ubicacione->nombre ?? '')))
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
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
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
                $sheet->getRowDimension(4)->setRowHeight(8);

                $sheet->mergeCells('A5:P5');
                $sheet->setCellValue('A5', 'INFORMACIÓN COMPLETA DE LOS EQUIPOS TECNOLÓGICOS');
                $sheet->getStyle('A5:P5')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->mergeCells('B6:I6');
                $sheet->mergeCells('J6:K6');
                $sheet->mergeCells('L6:P6');
                $sheet->setCellValue('B6', 'INFORMACIÓN GENERAL');
                $sheet->setCellValue('J6', 'DETALLES');
                $sheet->setCellValue('L6', 'ACCESORIOS');
                $sheet->setCellValue('A6', 'N°');
                $sheet->getStyle('A6:P6')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFD6A84F'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                $headers = [
                    'A7' => 'N°',
                    'B7' => 'TIPO',
                    'C7' => 'NÚM. SERIE',
                    'D7' => 'MARCA',
                    'E7' => 'MODELO',
                    'F7' => 'ESTADO',
                    'G7' => 'UBICACIÓN',
                    'H7' => 'FECHA REGISTRO',
                    'I7' => 'OBSERVACIONES',
                    'J7' => 'DETALLES',
                    'K7' => 'COLOR',
                    'L7' => 'TIPO',
                    'M7' => 'MARCA',
                    'N7' => 'SERIE',
                    'O7' => 'ESTADO',
                    'P7' => 'OBSERVACIONES',
                ];

                foreach ($headers as $celda => $valor) {
                    $sheet->setCellValue($celda, $valor);
                }

                $sheet->getStyle('A7:P7')->applyFromArray([
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
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);
                $sheet->getRowDimension(7)->setRowHeight(28);

                $highestRow = $sheet->getHighestRow();

                if ($highestRow >= 8) {
                    $sheet->getStyle('A8:P' . $highestRow)->applyFromArray([
                        'font' => ['size' => 9],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_TOP,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                    ]);

                    $sheet->getStyle('A8:A' . $highestRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    $sheet->getStyle('F8:H' . $highestRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    $sheet->getStyle('K8:O' . $highestRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    for ($fila = 8; $fila <= $highestRow; $fila++) {
                        $maxLineas = 1;

                        foreach (range('A', 'P') as $columna) {
                            $valor = $sheet->getCell($columna . $fila)->getValue();

                            if ($valor !== null) {
                                $lineas = substr_count((string) $valor, "\n") + 1;
                                $maxLineas = max($maxLineas, $lineas);
                            }
                        }

                        $sheet->getRowDimension($fila)->setRowHeight(max(22, $maxLineas * 15));
                    }

                    $sheet->setAutoFilter('A7:P' . $highestRow);
                }
            },
        ];
    }
}