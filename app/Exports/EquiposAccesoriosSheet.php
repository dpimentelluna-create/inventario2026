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

class EquiposAccesoriosSheet implements FromCollection, WithEvents, WithStyles, WithColumnWidths, WithTitle
{
    protected Collection $equipos;

    public function title(): string
    {
        return 'ACCESORIOS';
    }

    public function __construct(Collection $equipos)
    {
        $this->equipos = $equipos;
    }

    public function collection()
    {
        $filas = collect();

        // Espacio superior para el encabezado y los datos del reporte.
        for ($i = 1; $i <= 5; $i++) {
            $filas->push(array_fill(0, 8, ''));
        }

        // Encabezados de la hoja unificada.
        $filas->push([
            'N°',
            'TIPO ACCESORIO',
            'MARCA',
            'NUM. SERIE',
            'ESTADO',
            'OBSERVACIONES',
            'TIPO EQUIPO',
            'NUM SERIE',
        ]);

        $indice = 1;

        // 1. Accesorios relacionados con los equipos seleccionados.
        foreach ($this->equipos as $equipo) {
            $tipoEquipo = mb_strtoupper($equipo->tipoEquipo->nombre ?? '-');
            $serieEquipo = mb_strtoupper($equipo->num_serie ?? '-');

            $accesorios = $equipo->accesoriosEquipos ?? collect();

            foreach ($accesorios as $accesorio) {
                $filas->push([
                    $indice,
                    mb_strtoupper($accesorio->tipo ?? '-'),
                    mb_strtoupper($accesorio->marca ?? '-'),
                    mb_strtoupper($accesorio->num_serie ?? '-'),
                    mb_strtoupper($accesorio->estado ?? '-'),
                    mb_strtoupper($accesorio->observaciones ?? '-'),
                    $tipoEquipo,
                    $serieEquipo,
                ]);

                $indice++;
            }
        }

        // 2. Obtener las ubicaciones de los equipos seleccionados.
        $ubicacionIds = $this->equipos
            ->pluck('ubicacion_id')
            ->filter()
            ->unique()
            ->values();

        // 3. Accesorios independientes únicamente de esas ubicaciones.
        if ($ubicacionIds->isNotEmpty()) {
            $accesoriosIndependientes = AccesoriosEquipo::query()
                ->whereNull('equipo_id')
                ->whereIn('ubicacion_id', $ubicacionIds)
                ->orderBy('tipo')
                ->orderBy('marca')
                ->get();

            foreach ($accesoriosIndependientes as $accesorio) {
                $filas->push([
                    $indice,
                    mb_strtoupper($accesorio->tipo ?? '-'),
                    mb_strtoupper($accesorio->marca ?? '-'),
                    mb_strtoupper($accesorio->num_serie ?? '-'),
                    mb_strtoupper($accesorio->estado ?? '-'),
                    mb_strtoupper($accesorio->observaciones ?? '-'),
                    '-',
                    '-',
                ]);

                $indice++;
            }
        }

        return $filas;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 22,
            'C' => 20,
            'D' => 29,
            'E' => 15,
            'F' => 35,
            'G' => 20,
            'H' => 29,
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

                // Título principal.
                $sheet->mergeCells('A1:H1');
                $sheet->setCellValue('A1', 'FORMATO PARA REGISTRO DE EQUIPOS TECNOLOGICOS');

                $sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getRowDimension(1)->setRowHeight(22);

                // Información de ubicación del reporte.
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
                $sheet->setCellValue('F2', 'UBICACIÓN');
                $sheet->mergeCells('G2:H2');
                $sheet->setCellValue('G2', $ubicacionReporte);

                $sheet->setCellValue('B3', 'CARGO');
                $sheet->mergeCells('C3:E3');
                $sheet->setCellValue('C3', 'COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO');
                $sheet->setCellValue('F3', 'FECHA');
                $sheet->mergeCells('G3:H3');
                $sheet->setCellValue('G3', $fechaReporte);

                foreach (['B2:E2', 'F2:H2', 'B3:E3', 'F3:H3'] as $rango) {
                    $sheet->getStyle($rango)->applyFromArray([
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);
                }

                foreach (['B2', 'F2', 'B3', 'F3'] as $celda) {
                    $sheet->getStyle($celda)->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFD6A84F'],
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                        ],
                    ]);
                }

                $sheet->getRowDimension(2)->setRowHeight(18);
                $sheet->getRowDimension(3)->setRowHeight(18);
                $sheet->getRowDimension(4)->setRowHeight(8);

                // Subtítulo.
                $sheet->mergeCells('A5:H5');
                $sheet->setCellValue('A5', 'INVENTARIO DE ACCESORIOS');

                $sheet->getStyle('A5:H5')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Encabezados de las ocho columnas.
                $headers = [
                    'A6' => 'N°',
                    'B6' => 'TIPO ACCESORIO',
                    'C6' => 'MARCA',
                    'D6' => 'NUM. SERIE',
                    'E6' => 'ESTADO',
                    'F6' => 'OBSERVACIONES',
                    'G6' => 'TIPO EQUIPO',
                    'H6' => 'NUM SERIE',
                ];

                foreach ($headers as $celda => $valor) {
                    $sheet->setCellValue($celda, $valor);
                }

                $sheet->getStyle('A6:H6')->applyFromArray([
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

                $sheet->getRowDimension(6)->setRowHeight(28);

                $highestRow = $sheet->getHighestRow();

                if ($highestRow >= 7) {
                    // Formato general de las filas de accesorios.
                    $sheet->getStyle('A7:H' . $highestRow)->applyFromArray([
                        'font' => ['size' => 9],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                    ]);

                    $sheet->getDefaultRowDimension()->setRowHeight(24);

                    // Numeración como número entero con formato 01, 02, 03...
                    $sheet->getStyle('A7:A' . $highestRow)
                        ->getNumberFormat()
                        ->setFormatCode('00');

                    // Observaciones alineadas a la izquierda.
                    $sheet->getStyle('F7:F' . $highestRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                    // Fondo azul claro para los datos del equipo relacionado.
                    $sheet->getStyle('G7:H' . $highestRow)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFDDE8F3'],
                        ],
                    ]);

                    // Filtro de la tabla.
                    $sheet->setAutoFilter('A6:H' . $highestRow);
                }
            },
        ];
    }
}
