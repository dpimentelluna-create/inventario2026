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

    /*
    |--------------------------------------------------------------------------
    | FILAS RESERVADAS PARA EL ENCABEZADO
    |--------------------------------------------------------------------------
    |
    | IMPORTANTE:
    | No usar [] porque Laravel Excel puede omitir esas filas.
    | Se colocan 16 celdas vacías para mantener físicamente
    | las posiciones de las filas.
    |
    */

    for ($i = 1; $i <= 6; $i++) {
        $filas->push(array_fill(0, 16, ''));
    }

    /*
    |--------------------------------------------------------------------------
    | DATOS
    |--------------------------------------------------------------------------
    */

    $indice = 1;

    foreach ($this->equipos as $equipo) {

        foreach ($this->equipos as $equipo) {

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN GENERAL
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | DETALLES
            |--------------------------------------------------------------------------
            */

            $procesador = '';
            $ram = '';
            $disco = '';
            $color = '';
            $descripcion = '';

            if ($equipo->especificacionesLaptops) {

                $procesador = strtoupper(
                    $equipo->especificacionesLaptops->procesador ?? ''
                );

                $ram = strtoupper(
                    $equipo->especificacionesLaptops->ram ?? ''
                );

                $disco = strtoupper(
                    $equipo->especificacionesLaptops->disco_duro ?? ''
                );

                $color = strtoupper(
                    $equipo->especificacionesLaptops->color ?? ''
                );

            } elseif ($equipo->especificacionesEquipo) {

                $color = strtoupper(
                    $equipo->especificacionesEquipo->color ?? ''
                );

                $descripcion = strtoupper(
                    $equipo->especificacionesEquipo->descripcion ?? ''
                );
            }

            /*
            |--------------------------------------------------------------------------
            | ESTADO
            |--------------------------------------------------------------------------
            */

            $estado = strtoupper(
                $equipo->especificacionesLaptops->estado
                    ?? $equipo->especificacionesEquipo->estado
                    ?? '-'
            );

            /*
            |--------------------------------------------------------------------------
            | UBICACIÓN
            |--------------------------------------------------------------------------
            */

            $ubicacion = strtoupper(
                $equipo->ubicacione->nombre ?? '-'
            );

            /*
            |--------------------------------------------------------------------------
            | OBSERVACIÓN
            |--------------------------------------------------------------------------
            */

            $observacion = strtoupper(
                $equipo->especificacionesLaptops->observaciones
                    ?? $equipo->especificacionesEquipo->observaciones
                    ?? $equipo->observacion
                    ?? '-'
            );

            /*
            |--------------------------------------------------------------------------
            | DETALLES
            |--------------------------------------------------------------------------
            */

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

            $detallesTexto = !empty($detalles)
                ? implode("\n", $detalles)
                : '-';

            /*
            |--------------------------------------------------------------------------
            | ACCESORIOS
            |--------------------------------------------------------------------------
            */

            $tiposAccesorios = [];
            $marcasAccesorios = [];
            $seriesAccesorios = [];
            $estadosAccesorios = [];
            $observacionesAccesorios = [];

            foreach ($equipo->accesoriosEquipos ?? [] as $accesorio) {

                $tiposAccesorios[] = strtoupper(
                    $accesorio->tipo ?? '-'
                );

                $marcasAccesorios[] = strtoupper(
                    $accesorio->marca ?? '-'
                );

                $seriesAccesorios[] = strtoupper(
                    $accesorio->num_serie ?? '-'
                );

                $estadosAccesorios[] = strtoupper(
                    $accesorio->estado ?? '-'
                );

                $observacionesAccesorios[] = strtoupper(
                    $accesorio->observaciones ?? '-'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | FILA
            |--------------------------------------------------------------------------
            */

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
                !empty($tiposAccesorios)
                    ? implode("\n", $tiposAccesorios)
                    : '-',
                !empty($marcasAccesorios)
                    ? implode("\n", $marcasAccesorios)
                    : '-',
                !empty($seriesAccesorios)
                    ? implode("\n", $seriesAccesorios)
                    : '-',
                !empty($estadosAccesorios)
                    ? implode("\n", $estadosAccesorios)
                    : '-',
                !empty($observacionesAccesorios)
                    ? implode("\n", $observacionesAccesorios)
                    : '-',
            ]);

            $indice++;
        }

        return $filas;
    }
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

                /*
                |--------------------------------------------------------------------------
                | TÍTULO
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A1:P1');

                $sheet->setCellValue(
                    'A1',
                    'FORMATO PARA REGISTRO DE EQUIPOS TECNOLOGICOS'
                );

                $sheet->getStyle('A1:P1')->applyFromArray([
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

                $sheet->setCellValue('B2', 'RESPONSABLE');
                $sheet->mergeCells('C2:D2');
                $sheet->setCellValue(
                    'C2',
                    'ING. MICHAEL CABOS OLIVARES'
                );

                $sheet->setCellValue('E2', 'CARGO');
                $sheet->mergeCells('F2:P2');
                $sheet->setCellValue(
                    'F2',
                    'COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO'
                );

                $sheet->getStyle('B2:P2')->applyFromArray([
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

                $sheet->getStyle('C2:D2')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->getStyle('F2:P2')->getAlignment()
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

                $sheet->mergeCells('A4:P4');

                $sheet->setCellValue(
                    'A4',
                    'INFORMACIÓN COMPLETA DE LOS EQUIPOS TECNOLÓGICOS'
                );

                $sheet->getStyle('A4:P4')->applyFromArray([
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
                | GRUPOS
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('B5:I5');
                $sheet->mergeCells('J5:K5');
                $sheet->mergeCells('L5:P5');

                $sheet->setCellValue(
                    'B5',
                    'INFORMACIÓN GENERAL'
                );

                $sheet->setCellValue(
                    'J5',
                    'DETALLES'
                );

                $sheet->setCellValue(
                    'L5',
                    'ACCESORIOS'
                );

                $sheet->setCellValue('A5', 'N°');

                $sheet->getStyle('A5:P5')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 10,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFD6A84F',
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                /*
                |--------------------------------------------------------------------------
                | ENCABEZADOS DE COLUMNAS
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
                    'J6' => 'DETALLES',
                    'K6' => 'COLOR',
                    'L6' => 'TIPO',
                    'M6' => 'MARCA',
                    'N6' => 'SERIE',
                    'O6' => 'ESTADO',
                    'P6' => 'OBSERVACIONES',
                ];

                foreach ($headers as $celda => $valor) {
                    $sheet->setCellValue($celda, $valor);
                }

                $sheet->getStyle('A6:P6')->applyFromArray([
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
                        'A7:P' . $highestRow
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

                    $sheet->getStyle(
                        'K7:O' . $highestRow
                    )->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    /*
                    |--------------------------------------------------------------------------
                    | ALTURA AUTOMÁTICA APROXIMADA
                    |--------------------------------------------------------------------------
                    */

                    for ($fila = 7; $fila <= $highestRow; $fila++) {

                        $maxLineas = 1;

                        foreach (range('A', 'P') as $columna) {

                            $valor = $sheet->getCell(
                                $columna . $fila
                            )->getValue();

                            if ($valor !== null) {

                                $lineas = substr_count(
                                    (string) $valor,
                                    "\n"
                                ) + 1;

                                $maxLineas = max(
                                    $maxLineas,
                                    $lineas
                                );
                            }
                        }

                        $sheet->getRowDimension($fila)
                            ->setRowHeight(
                                max(22, $maxLineas * 15)
                            );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | FILTROS
                    |--------------------------------------------------------------------------
                    */

                    $sheet->setAutoFilter(
                        'A6:P' . $highestRow
                    );
                }
            },
        ];
    }
}