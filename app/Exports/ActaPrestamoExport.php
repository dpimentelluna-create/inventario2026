<?php

namespace App\Exports;

use App\Models\Prestamo;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ActaPrestamoExport implements FromArray, WithEvents
{
    public function __construct(protected Prestamo $prestamo)
    {
    }

    public function array(): array
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $this->pintar($sheet);
            },
        ];
    }

    private function pintar(Worksheet $sheet): void
    {
        $prestamo = $this->prestamo;
        $docente = $prestamo->docente;
        $textoLegal = 'Certifico que los elementos detallados en el presente documento, me han sido entregados para mi cuidado y custodia con el próposito de cumplir con las tareas y asignaciones propias a mi cargo, siendo estos de mi única y exclusiva responsabilidad. Me comprometo a usar correctamente los equipos y solo para uso de los fines establecidos, a no instalar ni permitir la instalacion de software por personas ajenas al grupo interno de trabajo de soporte técnico.';

        $sheet->getColumnDimension('A')->setWidth(3);
        foreach (['B' => 22, 'C' => 18, 'D' => 18, 'E' => 20, 'F' => 16, 'G' => 16, 'H' => 18] as $col => $ancho) {
            $sheet->getColumnDimension($col)->setWidth($ancho);
        }

        $sheet->mergeCells('B2:H2');
        $sheet->setCellValue('B2', 'INSTITUCION EDUCATIVA 88021 "ALFONSO UGARTE"');
        $sheet->mergeCells('B3:H3');
        $sheet->setCellValue('B3', 'ACTA DE ENTREGA DE EQUIPOS DE COMPUTO');

        $sheet->mergeCells('B5:H5');
        $sheet->setCellValue('B5', 'DATOS PERSONALES BENEFICIARIO');
        $personales = [
            6 => ['NOMBRES', $docente->nombres ?? ''],
            7 => ['APELLIDOS', $docente->apellidos ?? ''],
            8 => ['DNI', $docente->dni ?? ''],
            9 => ['CORREO', $docente->correo ?? ''],
            10 => ['CELULAR', $docente->celular ?? ''],
        ];
        foreach ($personales as $fila => [$etiqueta, $valor]) {
            $sheet->setCellValue('B' . $fila, $etiqueta);
            $sheet->mergeCells('C' . $fila . ':H' . $fila);
            $sheet->setCellValue('C' . $fila, mb_strtoupper((string) $valor));
        }

        $sheet->mergeCells('B13:H13');
        $sheet->setCellValue('B13', 'DATOS DEL EQUIPO');
        $sheet->mergeCells('B14:B15');
        $sheet->mergeCells('C14:C15');
        $sheet->mergeCells('D14:D15');
        $sheet->mergeCells('E14:E15');
        $sheet->mergeCells('F14:H14');
        $sheet->setCellValue('B14', 'EQUIPO');
        $sheet->setCellValue('C14', 'MARCA');
        $sheet->setCellValue('D14', 'MODELO');
        $sheet->setCellValue('E14', 'SERIE');
        $sheet->setCellValue('F14', 'ACCESORIO');
        $sheet->setCellValue('F15', 'MARCA');
        $sheet->setCellValue('G15', 'TIPO');
        $sheet->setCellValue('H15', 'SERIE');

        $fila = 16;
        $bloquesSpecs = [];

        foreach ($prestamo->prestamoEquipos as $prestamoEquipo) {
            $equipo = $prestamoEquipo->equipo;
            $accesorios = $prestamoEquipo->prestamoAccesorios;

            $marcas = [];
            $tipos = [];
            $series = [];
            foreach ($accesorios as $filaAcc) {
                $acc = $filaAcc->accesorioEquipo;
                $marcas[] = mb_strtoupper($acc->marca ?? '-');
                $tipos[] = mb_strtoupper($acc->tipo ?? '-');
                $series[] = mb_strtoupper($acc->num_serie ?? '-');
            }

            $sheet->setCellValue('B' . $fila, mb_strtoupper($equipo->tipoEquipo->nombre ?? '-'));
            $sheet->setCellValue('C' . $fila, mb_strtoupper($equipo->marca ?? '-'));
            $sheet->setCellValue('D' . $fila, mb_strtoupper($equipo->modelo ?? '-'));
            $sheet->setCellValue('E' . $fila, mb_strtoupper($equipo->num_serie ?? '-'));
            $sheet->setCellValue('F' . $fila, $marcas ? implode("\n", $marcas) : '-');
            $sheet->setCellValue('G' . $fila, $tipos ? implode("\n", $tipos) : '-');
            $sheet->setCellValue('H' . $fila, $series ? implode("\n", $series) : '-');
            $sheet->getStyle('B' . $fila . ':H' . $fila)->getAlignment()->setWrapText(true);
            $sheet->getRowDimension($fila)->setRowHeight(max(18, count($marcas) * 16));

            $laptop = $equipo->especificacionesLaptops;
            $otro = $equipo->especificacionesEquipo;
            $bloquesSpecs[] = [
                'equipo' => mb_strtoupper($equipo->tipoEquipo->nombre ?? 'EQUIPO'),
                'specs' => mb_strtoupper(implode(' | ', array_filter([
                    $laptop->procesador ?? null,
                    $laptop->ram ?? null,
                    $laptop->disco_duro ?? null,
                    $otro->descripcion ?? null,
                ]))) ?: '-',
                'color' => mb_strtoupper($laptop->color ?? $otro->color ?? '-'),
                'estado' => mb_strtoupper($prestamoEquipo->estado ?? $laptop->estado ?? $otro->estado ?? '-'),
                'observacion' => mb_strtoupper($prestamoEquipo->observacion ?? '-'),
            ];
            $fila++;
        }

        if ($fila === 16) {
            $fila = 17;
        }

        $filaEquipos = $fila; // última fila de datos de equipos + 1

        $fila += 1;
        $sheet->mergeCells('B' . $fila . ':H' . $fila);
        $sheet->setCellValue('B' . $fila, 'ESPECIFICACIONES GENERALES');
        $inicioSpecs = $fila;
        $fila++;

        foreach ($bloquesSpecs as $bloque) {
            $sheet->mergeCells('B' . $fila . ':E' . $fila);
            $sheet->setCellValue('B' . $fila, $bloque['equipo'] . ': ' . $bloque['specs']);
            $sheet->mergeCells('F' . $fila . ':H' . $fila);
            $sheet->setCellValue('F' . $fila, 'COLOR: ' . $bloque['color']);
            $fila++;

            $sheet->mergeCells('B' . $fila . ':D' . $fila);
            $sheet->setCellValue('B' . $fila, 'ESTADO: ' . $bloque['estado']);
            $sheet->mergeCells('E' . $fila . ':H' . $fila);
            $sheet->setCellValue('E' . $fila, 'OBSERVACIONES: ' . $bloque['observacion']);
            $fila++;
        }

        $filaAntesObs = $fila; // fila justo después de las especificaciones (antes del separador)

        $fila++;
        $sheet->mergeCells('B' . $fila . ':H' . $fila);
        $sheet->setCellValue('B' . $fila, 'OBSERVACIONES');
        $filaObs = $fila;
        $fila++;
        $sheet->mergeCells('B' . $fila . ':H' . ($fila + 1));
        $sheet->setCellValue('B' . $fila, $textoLegal);
        $sheet->getStyle('B' . $fila)->getAlignment()->setWrapText(true);
        $sheet->getRowDimension($fila)->setRowHeight(48);
        $fila += 3;

        $filaAntesEntrega = $fila; // fila justo después de las observaciones

        $sheet->mergeCells('B' . $fila . ':H' . $fila);
        $sheet->setCellValue('B' . $fila, 'ENTREGA DEL EQUIPO');
        $filaEntrega = $fila;
        $fila++;
        $sheet->mergeCells('B' . $fila . ':C' . $fila);
        $sheet->mergeCells('D' . $fila . ':E' . $fila);
        $sheet->mergeCells('F' . $fila . ':H' . $fila);
        $sheet->setCellValue('B' . $fila, 'RECIBE');
        $sheet->setCellValue('D' . $fila, 'ENTREGA');
        $sheet->setCellValue('F' . $fila, 'DEVOLUCION');
        $fila++;
        $sheet->mergeCells('B' . $fila . ':C' . ($fila + 1));
        $sheet->mergeCells('D' . $fila . ':E' . ($fila + 1));
        $sheet->mergeCells('F' . $fila . ':H' . ($fila + 1));
        $sheet->setCellValue('B' . $fila, 'NOMBRES: ' . mb_strtoupper(trim(($docente->nombres ?? '') . ' ' . ($docente->apellidos ?? ''))));
        $sheet->setCellValue('D' . $fila, 'NOMBRES: MICHAEL RAUL CABOS OLIVARES');
        $sheet->setCellValue('F' . $fila, 'NOMBRES:');
        $fila += 2;
        $sheet->mergeCells('B' . $fila . ':C' . ($fila + 1));
        $sheet->mergeCells('D' . $fila . ':E' . ($fila + 1));
        $sheet->mergeCells('F' . $fila . ':H' . ($fila + 1));
        $sheet->setCellValue('B' . $fila, 'FIRMA:');
        $sheet->setCellValue('D' . $fila, 'FIRMA:');
        $sheet->setCellValue('F' . $fila, 'FIRMA:');
        $fila += 2;
        $fecha = $prestamo->fecha ? $prestamo->fecha->format('d/m/Y') : '';
        $sheet->mergeCells('B' . $fila . ':C' . $fila);
        $sheet->mergeCells('D' . $fila . ':E' . $fila);
        $sheet->mergeCells('F' . $fila . ':H' . $fila);
        $sheet->setCellValue('B' . $fila, 'FECHA: ' . $fecha);
        $sheet->setCellValue('D' . $fila, 'FECHA: ' . $fecha);
        $sheet->setCellValue('F' . $fila, 'FECHA:');
        $ultima = $fila;

        // Estilos de títulos principales
        $sheet->getStyle('B2:H3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Cabeceras de sección (fondo azul)
        foreach ([
            'B5:H5',
            'B13:H13',
            'B' . $inicioSpecs . ':H' . $inicioSpecs,
            'B' . $filaObs . ':H' . $filaObs,
            'B' . $filaEntrega . ':H' . $filaEntrega,
        ] as $rango) {
            $sheet->getStyle($rango)->applyFromArray([
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
        }

        // Cabecera de la tabla de equipos (fondo dorado)
        $sheet->getStyle('B14:H15')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD6A84F']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        // Alineación general y wrap (sin bordes todavía)
        $sheet->getStyle('B2:H' . $ultima)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B2:H' . $ultima)->getAlignment()->setWrapText(true);
        $sheet->getStyle('B2:H3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Bordes solo en los bloques de contenido (sin tocar filas vacías de separación)
        $rangosConBorde = [
            'B2:H3',                    // Títulos
            'B5:H10',                   // Datos personales
            'B13:H' . ($filaEquipos - 1), // Tabla de equipos (cabecera + datos)
            'B' . $inicioSpecs . ':H' . ($filaAntesObs - 1), // Especificaciones
            'B' . $filaObs . ':H' . ($filaAntesEntrega - 1), // Observaciones
            'B' . $filaEntrega . ':H' . $ultima,             // Entrega
        ];

        foreach ($rangosConBorde as $rango) {
            $sheet->getStyle($rango)->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]);
        }

        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(1);
    }
}