<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class EquiposAccesoriosSheet implements FromCollection, WithEvents, WithStyles, WithColumnWidths
{
    protected Collection $equipos;

    public function __construct(Collection $equipos)
    {
        $this->equipos = $equipos;
    }

    public function collection()
    {
        $filas = collect();

        for ($i = 1; $i <= 4; $i++) {
    $filas->push(array_fill(0, 8, ''));
}

        // Encabezados
        $filas->push([
            'N°',
            'TIPO',
            'NÚM. SERIE',
            'TIPO ACCESORIO',
            'MARCA',
            'SERIE',
            'ESTADO',
            'OBSERVACIONES',
        ]);

        $indice = 1;

        foreach ($this->equipos as $equipo) {

            $tipo = strtoupper(
                $equipo->tipoEquipo->nombre ?? '-'
            );

            $serieEquipo = strtoupper(
                $equipo->num_serie ?? '-'
            );

            /*
            |--------------------------------------------------------------------------
            | ACCESORIOS DEL EQUIPO
            |--------------------------------------------------------------------------
            */

            $accesorios = $equipo->accesoriosEquipos ?? collect();

            /*
            |--------------------------------------------------------------------------
            | SI EL EQUIPO NO TIENE ACCESORIOS
            |--------------------------------------------------------------------------
            */

            if ($accesorios->isEmpty()) {

                $filas->push([
                    sprintf('%02d', $indice),
                    $tipo,
                    $serieEquipo,
                    '-',
                    '-',
                    '-',
                    '-',
                    'SIN ACCESORIOS REGISTRADOS',
                ]);

            }

            /*
            |--------------------------------------------------------------------------
            | SI EL EQUIPO TIENE ACCESORIOS
            |--------------------------------------------------------------------------
            */

            else {

                foreach ($accesorios as $accesorio) {

                    $filas->push([
                        sprintf('%02d', $indice),
                        $tipo,
                        $serieEquipo,

                        strtoupper(
                            $accesorio->tipo ?? '-'
                        ),

                        strtoupper(
                            $accesorio->marca ?? '-'
                        ),

                        strtoupper(
                            $accesorio->num_serie ?? '-'
                        ),

                        strtoupper(
                            $accesorio->estado ?? '-'
                        ),

                        strtoupper(
                            $accesorio->observaciones
                                ?? '-'
                        ),
                    ]);
                }
            }

            $indice++;
        }

        return $filas;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 20,
            'C' => 22,
            'D' => 22,
            'E' => 20,
            'F' => 22,
            'G' => 15,
            'H' => 35,
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

                /*
                |--------------------------------------------------------------------------
                | TÍTULO
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A1:H1');

                $sheet->setCellValue(
                    'A1',
                    'FORMATO PARA REGISTRO DE EQUIPOS TECNOLOGICOS'
                );

                $sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getRowDimension(1)->setRowHeight(22);

                /*
                |--------------------------------------------------------------------------
                | RESPONSABLE / CARGO
                |--------------------------------------------------------------------------
                */

                $sheet->setCellValue(
                    'B2',
                    'RESPONSABLE'
                );

                $sheet->mergeCells('C2:D2');

                $sheet->setCellValue(
                    'C2',
                    'ING. MICHAEL CABOS OLIVARES'
                );

                $sheet->setCellValue(
                    'E2',
                    'CARGO'
                );

                $sheet->mergeCells('F2:H2');

                $sheet->setCellValue(
                    'F2',
                    'COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO'
                );

                $sheet->getStyle('B2:H2')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('B2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFD6A84F',
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('E2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFD6A84F',
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('C2:D2')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->getStyle('F2:H2')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->getRowDimension(2)->setRowHeight(18);

                /*
                |--------------------------------------------------------------------------
                | ESPACIO
                |--------------------------------------------------------------------------
                */

                $sheet->getRowDimension(3)->setRowHeight(8);

                /*
                |--------------------------------------------------------------------------
                | SUBTÍTULO
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A4:H4');

                $sheet->setCellValue(
                    'A4',
                    'ACCESORIOS DE LOS EQUIPOS TECNOLÓGICOS'
                );

                $sheet->getStyle('A4:H4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                /*
                |--------------------------------------------------------------------------
                | ENCABEZADOS
                |--------------------------------------------------------------------------
                */

                $headers = [
                    'A5' => 'N°',
                    'B5' => 'TIPO',
                    'C5' => 'NÚM. SERIE',
                    'D5' => 'TIPO ACCESORIO',
                    'E5' => 'MARCA',
                    'F5' => 'SERIE',
                    'G5' => 'ESTADO',
                    'H5' => 'OBSERVACIONES',
                ];

                foreach ($headers as $celda => $valor) {
                    $sheet->setCellValue($celda, $valor);
                }

                $sheet->getStyle('A5:H5')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 9,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FF90EE90',
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $sheet->getRowDimension(5)->setRowHeight(28);

                /*
                |--------------------------------------------------------------------------
                | DATOS
                |--------------------------------------------------------------------------
                */

                $highestRow = $sheet->getHighestRow();

                if ($highestRow >= 6) {

                    $sheet->getStyle(
                        'A6:H' . $highestRow
                    )->applyFromArray([
                        'font' => [
                            'size' => 9,
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_TOP,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                    ]);

                    $sheet->getStyle(
                        'A6:A' . $highestRow
                    )->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    $sheet->getStyle(
                        'G6:G' . $highestRow
                    )->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    /*
                    |--------------------------------------------------------------------------
                    | FILTROS
                    |--------------------------------------------------------------------------
                    */

                    $sheet->setAutoFilter(
                        'A5:H' . $highestRow
                    );
                }
            },
        ];
    }
}