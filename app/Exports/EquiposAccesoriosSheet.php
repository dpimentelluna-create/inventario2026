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

        for ($i = 1; $i <= 5; $i++) {
            $filas->push(array_fill(0, 8, ''));
        }

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
            $tipo = strtoupper($equipo->tipoEquipo->nombre ?? '-');
            $serieEquipo = strtoupper($equipo->num_serie ?? '-');
            $accesorios = $equipo->accesoriosEquipos ?? collect();

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
            } else {
                foreach ($accesorios as $accesorio) {
                    $filas->push([
                        sprintf('%02d', $indice),
                        $tipo,
                        $serieEquipo,
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
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);
                }

                foreach (['B2', 'F2', 'B3', 'F3'] as $celda) {
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

                $sheet->mergeCells('A5:H5');
                $sheet->setCellValue('A5', 'ACCESORIOS DE LOS EQUIPOS TECNOLÓGICOS');
                $sheet->getStyle('A5:H5')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $headers = [
                    'A6' => 'N°',
                    'B6' => 'TIPO',
                    'C6' => 'NÚM. SERIE',
                    'D6' => 'TIPO ACCESORIO',
                    'E6' => 'MARCA',
                    'F6' => 'SERIE',
                    'G6' => 'ESTADO',
                    'H6' => 'OBSERVACIONES',
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
                    $sheet->getStyle('A7:H' . $highestRow)->applyFromArray([
                        'font' => ['size' => 9],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_TOP,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                    ]);

                    $sheet->getStyle('A7:A' . $highestRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    $sheet->getStyle('G7:G' . $highestRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    $sheet->setAutoFilter('A6:H' . $highestRow);
                }
            },
        ];
    }
}