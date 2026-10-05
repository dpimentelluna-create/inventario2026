<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Collection;

class PrestamosExport implements FromCollection, WithEvents, WithStyles, WithColumnWidths
{
    protected Collection $prestamos;

    public function __construct(Collection $prestamos)
    {
        $this->prestamos = $prestamos;
    }

    public function collection()
    {
        $rows = collect();

        // Fila vacía para el título (se llena en AfterSheet)
        $rows->push(['', '', '', '', '', '', '', '', '']);
        
        // Fila vacía para el título (se llena en AfterSheet)
        $rows->push(['', '', '', '', '', '', '', '', '']);

        // Fila RESPONSABLE / CARGO (se llena en AfterSheet)
        $rows->push(['', '', '', '', '', '', '', '', '']);

        // Fila subtítulo (se llena en AfterSheet)
        $rows->push(['', '', '', '', '', '', '', '', '']);

        // Encabezados de la tabla
        $rows->push([
            'N°',
            'APELLIDOS Y NOMBRES',
            'CARGO',
            'EQUIPO TECNOLOGICO',
            'FECHA',
            'HORA DESDE',
            'HORA HASTA',
            'ESTADO',
            'OBSERVACION',
        ]);

        // Datos
        foreach ($this->prestamos as $indice => $p) {
            $nombre = mb_strtoupper(trim(($p->docente->apellidos ?? '') . ' ' . ($p->docente->nombres ?? '')), 'UTF-8');
            $cargo  = mb_strtoupper($p->cargo ?? '', 'UTF-8');
            $estado = mb_strtoupper($p->estado ?? '', 'UTF-8');

            // Fecha
            $fecha = '-';
            if ($p->fecha) {
                try {
                    $fecha = \Carbon\Carbon::parse($p->fecha)->format('d/m/Y');
                } catch (\Exception $e) {
                    $fecha = $p->fecha;
                }
            }

            // Hora inicio
            $horaInicio = '-';
            if ($p->hora_inicio) {
                try {
                    $horaInicio = \Carbon\Carbon::createFromFormat('H:i', substr($p->hora_inicio, 0, 5))->format('h:i A');
                } catch (\Exception $e) {
                    $horaInicio = substr($p->hora_inicio, 0, 5);
                }
            }

            // Hora fin
            $horaFin = '-';
            if ($p->hora_fin) {
                try {
                    $horaFin = \Carbon\Carbon::createFromFormat('H:i', substr($p->hora_fin, 0, 5))->format('h:i A');
                } catch (\Exception $e) {
                    $horaFin = substr($p->hora_fin, 0, 5);
                }
            }

            // =========================================================
// EQUIPOS + ACCESORIOS
// Cada equipo y sus accesorios forman un bloque.
// Se deja una línea vacía entre equipos.
// =========================================================

$bloquesEquipos = [];

foreach ($p->prestamoEquipos as $pe) {

    $eq = $pe->equipo;

    $tipo = mb_strtoupper(
        $eq->tipoEquipo->nombre ?? '',
        'UTF-8'
    );

    $marca = mb_strtoupper(
        $eq->marca ?? '',
        'UTF-8'
    );

    $modelo = mb_strtoupper(
        $eq->modelo ?? '',
        'UTF-8'
    );

    $serie = mb_strtoupper(
        $eq->num_serie ?? '',
        'UTF-8'
    );


    // -----------------------------------------
    // EQUIPO
    // -----------------------------------------

    $bloque = [];

    $lineaEquipo = 'EQUIPO: ' . ($tipo ?: '-');

    if ($marca) {
        $lineaEquipo .= ' | ' . $marca;
    }

    if ($modelo) {
        $lineaEquipo .= ' | ' . $modelo;
    }

    if ($serie) {
        $lineaEquipo .= ' | N/S ' . $serie;
    }

    $bloque[] = $lineaEquipo;


    // -----------------------------------------
    // ACCESORIOS DEL EQUIPO
    // -----------------------------------------

    foreach ($pe->prestamoAccesorios as $pa) {

        $acc = $pa->accesorioEquipo;

        $tipoAcc = mb_strtoupper(
            $acc->tipo ?? '',
            'UTF-8'
        );

        $marcaAcc = mb_strtoupper(
            $acc->marca ?? '',
            'UTF-8'
        );

        $serieAcc = mb_strtoupper(
            $acc->num_serie ?? '',
            'UTF-8'
        );


        $lineaAcc = 'ACCESORIO: ' . ($tipoAcc ?: '-');

        if ($marcaAcc) {
            $lineaAcc .= ' | ' . $marcaAcc;
        }

        if ($serieAcc) {
            $lineaAcc .= ' | N/S ' . $serieAcc;
        }

        $bloque[] = $lineaAcc;
    }


    // Guardamos el equipo con todos sus accesorios
    $bloquesEquipos[] = implode("\n", $bloque);
}


// Línea vacía entre cada equipo
$equiposCelda = !empty($bloquesEquipos)
    ? implode("\n\n", $bloquesEquipos)
    : '-';

            // =========================================================
// OBSERVACIONES
// Cada equipo y sus accesorios forman un bloque.
// Se deja una línea vacía entre equipos.
// =========================================================

$bloquesObservaciones = [];

foreach ($p->prestamoEquipos as $pe) {

    $bloqueObservacion = [];

    $obsEq = mb_strtoupper(
        trim($pe->observacion ?? ''),
        'UTF-8'
    );

    $tipoEq = mb_strtoupper(
        $pe->equipo->tipoEquipo->nombre ?? '',
        'UTF-8'
    );


    // -----------------------------------------
    // OBSERVACIÓN DEL EQUIPO
    // -----------------------------------------

    if ($obsEq) {

        $bloqueObservacion[] =
            'EQUIPO: ' .
            ($tipoEq ?: '-') .
            ' | ' .
            $obsEq;
    }


    // -----------------------------------------
    // OBSERVACIONES DE ACCESORIOS
    // -----------------------------------------

    foreach ($pe->prestamoAccesorios as $pa) {

        $obsAcc = mb_strtoupper(
            trim($pa->observacion ?? ''),
            'UTF-8'
        );

        $tipoAcc = mb_strtoupper(
            $pa->accesorioEquipo->tipo ?? '',
            'UTF-8'
        );


        if ($obsAcc) {

            $bloqueObservacion[] =
                'ACCESORIO: ' .
                ($tipoAcc ?: '-') .
                ' | ' .
                $obsAcc;
        }
    }


    // Solo agregamos el bloque si tiene contenido
    if (!empty($bloqueObservacion)) {

        $bloquesObservaciones[] =
            implode("\n", $bloqueObservacion);
    }
}


// Línea vacía entre las observaciones de cada equipo
$obsCelda = !empty($bloquesObservaciones)
    ? implode("\n\n", $bloquesObservaciones)
    : '-';


            $rows->push([
                sprintf('%02d', $indice + 1),
                $nombre ?: '-',
                $cargo ?: '-',
                $equiposCelda,
                $fecha,
                $horaInicio,
                $horaFin,
                $estado ?: '-',
                $obsCelda,
            ]);
        }

        return $rows;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,   // N°
            'B' => 28,  // APELLIDOS Y NOMBRES
            'C' => 16,  // CARGO
            'D' => 45,  // EQUIPO TECNOLOGICO
            'E' => 12,  // FECHA
            'F' => 12,  // HORA DESDE
            'G' => 12,  // HORA HASTA
            'H' => 12,  // ESTADO
            'I' => 35,  // OBSERVACION
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Se aplican estilos más completos en AfterSheet
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // ===== FILA 1: TÍTULO =====
                $sheet->mergeCells('A1:I1');
                $sheet->setCellValue('A1', 'FORMATO PARA PRESTAMO DE EQUIPOS TECNOLOGICOS');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(22);

                // =========================================================
// FILA 2: RESPONSABLE / CARGO
// =========================================================

// RESPONSABLE → B
$sheet->setCellValue('B2', 'RESPONSABLE');

// ING. MICHAEL... → C:D
$sheet->setCellValue(
    'C2',
    'ING. MICHAEL CABOS OLIVARES'
);

$sheet->mergeCells('C2:D2');

// CARGO → E
$sheet->setCellValue('E2', 'CARGO');

// COORDINADOR... → F:I
$sheet->setCellValue(
    'F2',
    'COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO'
);

$sheet->mergeCells('F2:I2');


// ---------------------------------------------------------
// ESTILO RESPONSABLE
// ---------------------------------------------------------

$sheet->getStyle('B2')->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 9,
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


// ---------------------------------------------------------
// VALOR RESPONSABLE → C:D
// ---------------------------------------------------------

$sheet->getStyle('C2:D2')->applyFromArray([
    'font' => [
        'size' => 9,
    ],
    'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
]);


// ---------------------------------------------------------
// ESTILO CARGO
// ---------------------------------------------------------

$sheet->getStyle('E2')->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 9,
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


// ---------------------------------------------------------
// VALOR CARGO → F:I
// ---------------------------------------------------------

$sheet->getStyle('F2:I2')->applyFromArray([
    'font' => [
        'size' => 9,
    ],
    'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
]);

$sheet->getRowDimension(2)->setRowHeight(18);



// =========================================================
// FILA 3: VACÍA
// =========================================================

// La fila 3 queda completamente vacía.
// Se utiliza como separación visual entre el encabezado
// y la información de la tabla.

$sheet->getRowDimension(3)->setRowHeight(8);


// =========================================================
// FILA 4: SUBTÍTULO
// =========================================================

$sheet->mergeCells('B4:I4');

$sheet->setCellValue(
    'B4',
    'DATOS DEL SOLICITANTE Y EQUIPO TECNOLOGICO'
);

$sheet->getStyle('B4:I4')->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 11,
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
]);

$sheet->getRowDimension(4)->setRowHeight(18);


// =========================================================
// FILA 5: ENCABEZADOS DE LA TABLA
// =========================================================

$sheet->getStyle('A5:I5')->applyFromArray([
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

$sheet->getRowDimension(5)->setRowHeight(22);

                // ===== DATOS (filas 6 en adelante) =====
                if ($highestRow >= 6) {

    $sheet->getStyle('A6:I' . $highestRow)->applyFromArray([
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

    // N°
    $sheet->getStyle('A6:A' . $highestRow)
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // FECHA, HORAS Y ESTADO
    $sheet->getStyle('E6:H' . $highestRow)
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
}   

                // Ajustar altura de filas de datos según contenido
                for ($row = 6; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1); // auto
                }
            },
        ];
    }
}