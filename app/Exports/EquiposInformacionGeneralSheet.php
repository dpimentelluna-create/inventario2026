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

class EquiposInformacionGeneralSheet implements FromCollection, WithEvents, WithStyles, WithColumnWidths
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
            $filas->push(array_fill(0, 9, ''));
        }

        // Encabezados
        $filas->push([
            'N°',
            'TIPO',
            'NÚM. SERIE',
            'MARCA',
            'MODELO',
            'ESTADO',
            'UBICACIÓN',
            'FECHA REGISTRO',
            'OBSERVACIONES',
        ]);

        $indice = 1;

        foreach ($this->equipos as $equipo) {

            $tipo = strtoupper(
                $equipo->tipoEquipo->nombre ?? '-'
            );

            $serie = strtoupper(
                $equipo->num_serie ?? '-'
            );

            $marca = strtoupper(
                $equipo->marca ?? '-'
            );

            $modelo = strtoupper(
                $equipo->modelo ?? '-'
            );

            $estado = strtoupper(
                $equipo->especificacionesLaptops->estado
                    ?? $equipo->especificacionesEquipo->estado
                    ?? '-'
            );

            $ubicacion = strtoupper(
                $equipo->ubicacione->nombre ?? '-'
            );

            $fecha = $equipo->fecha_registro
                ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d/m/Y')
                : '-';

            $observacion = strtoupper(
                $equipo->especificacionesLaptops->observaciones
                    ?? $equipo->especificacionesEquipo->observaciones
                    ?? $equipo->observacion
                    ?? '-'
            );

            $filas->push([
                sprintf('%02d', $indice),
                $tipo,
                $serie,
                $marca,
                $modelo,
                $estado,
                $ubicacion,
                $fecha,
                $observacion,
            ]);

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
            'D' => 20,
            'E' => 20,
            'F' => 15,
            'G' => 22,
            'H' => 16,
            'I' => 35,
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

                $sheet->mergeCells('A1:I1');

                $sheet->setCellValue(
                    'A1',
                    'FORMATO PARA REGISTRO DE EQUIPOS TECNOLOGICOS'
                );

                $sheet->getStyle('A1:I1')->applyFromArray([
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

                $ubicaciones = $this->equipos
                    ->map(fn($equipo) => mb_strtoupper(trim($equipo->ubicacione->nombre ?? '')))
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

                /*
                |--------------------------------------------------------------------------
                | ESPACIO
                |--------------------------------------------------------------------------
                */

                $sheet->getRowDimension(4)->setRowHeight(8);

                /*
                |--------------------------------------------------------------------------
                | SUBTÍTULO
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A5:I5');

                $sheet->setCellValue(
                    'A5',
                    'INFORMACIÓN GENERAL DE LOS EQUIPOS TECNOLÓGICOS'
                );

                $sheet->getStyle('A5:I5')->applyFromArray([
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
                    'A6' => 'N°',
                    'B6' => 'TIPO',
                    'C6' => 'NÚM. SERIE',
                    'D6' => 'MARCA',
                    'E6' => 'MODELO',
                    'F6' => 'ESTADO',
                    'G6' => 'UBICACIÓN',
                    'H6' => 'FECHA REGISTRO',
                    'I6' => 'OBSERVACIONES',
                ];

                foreach ($headers as $celda => $valor) {
                    $sheet->setCellValue($celda, $valor);
                }

                $sheet->getStyle('A6:I6')->applyFromArray([
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

                $sheet->getRowDimension(6)->setRowHeight(28);

                /*
                |--------------------------------------------------------------------------
                | DATOS
                |--------------------------------------------------------------------------
                */

                $highestRow = $sheet->getHighestRow();

                if ($highestRow >= 7) {

                    $sheet->getStyle(
                        'A7:I' . $highestRow
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
                        'A7:A' . $highestRow
                    )->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    $sheet->getStyle(
                        'F7:H' . $highestRow
                    )->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    /*
                    |--------------------------------------------------------------------------
                    | FILTROS
                    |--------------------------------------------------------------------------
                    */

                    $sheet->setAutoFilter(
                        'A6:I' . $highestRow
                    );
                }
            },
        ];
    }
}
