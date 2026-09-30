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

            // Equipos + Accesorios (con saltos de línea)
            $equiposTexto = [];
            foreach ($p->prestamoEquipos as $pe) {
                $eq = $pe->equipo;
                $tipo   = mb_strtoupper($eq->tipoEquipo->nombre ?? '', 'UTF-8');
                $marca  = mb_strtoupper($eq->marca ?? '', 'UTF-8');
                $modelo = mb_strtoupper($eq->modelo ?? '', 'UTF-8');
                $serie  = mb_strtoupper($eq->num_serie ?? '', 'UTF-8');

                $linea = 'EQUIPO: ' . ($tipo ?: '-');
                if ($marca)  $linea .= ' | ' . $marca;
                if ($modelo) $linea .= ' | ' . $modelo;
                if ($serie)  $linea .= ' | N/S ' . $serie;
                $equiposTexto[] = $linea;

                foreach ($pe->prestamoAccesorios as $pa) {
                    $acc = $pa->accesorioEquipo;
                    $tipoAcc  = mb_strtoupper($acc->tipo ?? '', 'UTF-8');
                    $marcaAcc = mb_strtoupper($acc->marca ?? '', 'UTF-8');
                    $serieAcc = mb_strtoupper($acc->num_serie ?? '', 'UTF-8');

                    $lineaAcc = 'ACCESORIO: ' . ($tipoAcc ?: '-');
                    if ($marcaAcc) $lineaAcc .= ' | ' . $marcaAcc;
                    if ($serieAcc) $lineaAcc .= ' | N/S ' . $serieAcc;
                    $equiposTexto[] = $lineaAcc;
                }
            }
            $equiposCelda = !empty($equiposTexto) ? implode("\n", $equiposTexto) : '-';

            // Observaciones (con saltos de línea)
            $obsTexto = [];
            foreach ($p->prestamoEquipos as $pe) {
                $obsEq = mb_strtoupper(trim($pe->observacion ?? ''), 'UTF-8');
                $tipoEq = mb_strtoupper($pe->equipo->tipoEquipo->nombre ?? '', 'UTF-8');
                if ($obsEq) {
                    $obsTexto[] = 'EQUIPO: ' . $tipoEq . ' | ' . $obsEq;
                }

                foreach ($pe->prestamoAccesorios as $pa) {
                    $obsAcc = mb_strtoupper(trim($pa->observacion ?? ''), 'UTF-8');
                    $tipoAcc = mb_strtoupper($pa->accesorioEquipo->tipo ?? '', 'UTF-8');
                    if ($obsAcc) {
                        $obsTexto[] = 'ACCESORIO: ' . $tipoAcc . ' | ' . $obsAcc;
                    }
                }
            }
            $obsCelda = !empty($obsTexto) ? implode("\n", $obsTexto) : '-';

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

                // ===== FILA 2: RESPONSABLE / CARGO =====
                $sheet->setCellValue('A2', 'RESPONSABLE');
                $sheet->setCellValue('B2', 'ING. MICHAEL CABOS OLIVARES');
                $sheet->mergeCells('B2:C2');
                $sheet->setCellValue('D2', 'CARGO');
                $sheet->setCellValue('E2', 'COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO');
                $sheet->mergeCells('E2:I2');

                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 9],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFD6A84F'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                $sheet->getStyle('B2:C2')->applyFromArray([
                    'font' => ['size' => 9],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                $sheet->getStyle('D2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 9],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFD6A84F'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                $sheet->getStyle('E2:I2')->applyFromArray([
                    'font' => ['size' => 9],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                $sheet->getRowDimension(2)->setRowHeight(18);

                // ===== FILA 3: SUBTÍTULO =====
                $sheet->mergeCells('A3:I3');
                $sheet->setCellValue('A3', 'DATOS DEL SOLICITANTE Y EQUIPO TECNOLOGICO');
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension(3)->setRowHeight(18);

                // ===== FILA 4: ENCABEZADOS DE TABLA =====
                $sheet->getStyle('A4:I4')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 9],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF90EE90'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);
                $sheet->getRowDimension(4)->setRowHeight(22);

                // ===== DATOS (filas 5 en adelante) =====
                if ($highestRow >= 5) {
                    $sheet->getStyle('A5:I' . $highestRow)->applyFromArray([
                        'font' => ['size' => 9],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_TOP,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                    ]);

                    // Centrar columnas numéricas / fecha / horas / estado
                    $sheet->getStyle('A5:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('E5:H' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // Ajustar altura de filas de datos según contenido
                for ($row = 5; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1); // auto
                }
            },
        ];
    }
}