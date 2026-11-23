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

class BajasEquiposExport implements FromCollection, WithEvents, WithStyles, WithColumnWidths
{
    protected Collection $bajas;

    public function __construct(Collection $bajas)
    {
        $this->bajas = $bajas;
    }

    /**
     * Construir las filas del archivo Excel.
     */
    public function collection()
    {
        $filas = collect();

        // Encabezado institucional.
        $filas->push([
            'FORMATO DE BAJAS ADMINISTRATIVAS DE EQUIPOS',
        ]);

        $filas->push([
            'RESPONSABLE',
            '',
            'ING. MICHAEL CABOS OLIVARES',
        ]);

        $filas->push([
            'CARGO',
            '',
            'COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO',
        ]);

        $filas->push([
            'HISTORIAL DE BAJAS ADMINISTRATIVAS',
        ]);

        // Encabezados de la tabla.
        $filas->push([
            'N°',
            'ID',
            'FECHA',
            'EQUIPO Y SERIE',
            'DESTINO',
            'QUIÉN ENTREGA',
            'QUIÉN RECIBE',
            'ACCESORIOS',
            'ESTADO',
            'OBSERVACIONES',
            'ANULACIÓN',
        ]);

        // Información de cada baja.
        foreach ($this->bajas as $indice => $baja) {
            $equipo = $baja->equipo;

            $tipo = $equipo->tipoEquipo->nombre ?? 'SIN TIPO';
            $marca = $equipo->marca ?? '';
            $modelo = $equipo->modelo ?? '';
            $serie = $equipo->num_serie ?? '';
            $ubicacion = $equipo->ubicacione->nombre ?? '';

            $datosEquipo = [
                'TIPO: ' . $tipo,
                'MARCA: ' . ($marca ?: '-'),
                'MODELO: ' . ($modelo ?: '-'),
                'N/S: ' . ($serie ?: '-'),
                'UBICACIÓN: ' . ($ubicacion ?: '-'),
            ];

            $equipoTexto = mb_strtoupper(
                implode("\n", $datosEquipo),
                'UTF-8'
            );

            // Personas que entregan y reciben.
            $entregantes = $this->formatearIntegrantes($baja->entregantes);
            $receptores = $this->formatearIntegrantes($baja->receptores);

            // Accesorios incluidos en la baja.
            $accesorios = $baja->accesoriosIncluidos
                ->map(function ($accesorio) {
                    $detalle = $accesorio->tipo ?? 'ACCESORIO';

                    if ($accesorio->marca) {
                        $detalle .= ' | MARCA: ' . $accesorio->marca;
                    }

                    if ($accesorio->modelo) {
                        $detalle .= ' | MODELO: ' . $accesorio->modelo;
                    }

                    if ($accesorio->num_serie) {
                        $detalle .= ' | N/S: ' . $accesorio->num_serie;
                    }

                    return mb_strtoupper($detalle, 'UTF-8');
                })
                ->implode("\n");

            // Información de anulación.
            $anulacion = '-';

            if ($baja->estado === 'ANULADA') {
                $fechaAnulacion = $baja->anulada_at
                    ? $baja->anulada_at->format('d/m/Y h:i A')
                    : '-';

                $usuario = $baja->anuladaPor->name
                    ?? 'USUARIO NO DISPONIBLE';

                $anulacion = "FECHA: {$fechaAnulacion}\nUSUARIO: {$usuario}";
            }

            $fecha = $baja->fecha
                ? $baja->fecha->format('d/m/Y')
                : '-';

            $filas->push([
                sprintf('%02d', $indice + 1),
                $baja->id,
                $fecha,
                $equipoTexto,
                mb_strtoupper($baja->destino ?? '-', 'UTF-8'),
                $entregantes,
                $receptores,
                $accesorios ?: '-',
                mb_strtoupper($baja->estado ?? '-', 'UTF-8'),
                mb_strtoupper($baja->observaciones ?? '-', 'UTF-8'),
                mb_strtoupper($anulacion, 'UTF-8'),
            ]);
        }

        return $filas;
    }

    /**
     * Preparar la lista de integrantes.
     */
    private function formatearIntegrantes($integrantes): string
    {
        if (!is_array($integrantes) || empty($integrantes)) {
            return '-';
        }

        return collect($integrantes)
            ->map(function ($persona, $indice) {
                $nombre = $persona['nombre'] ?? '';
                $cargo = $persona['cargo'] ?? '';

                return ($indice + 1) . '. '
                    . mb_strtoupper($nombre, 'UTF-8')
                    . "\nCARGO: "
                    . mb_strtoupper($cargo, 'UTF-8');
            })
            ->implode("\n\n");
    }

    /**
     * Aplicar estilos a la tabla.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            5 => [
                'font' => [
                    'bold' => true,
                    'size' => 10,
                    'color' => ['rgb' => '000000'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '90EE90'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
            ],
        ];
    }

    /**
     * Ajustar el ancho de las columnas.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 8,
            'C' => 13,
            'D' => 35,
            'E' => 25,
            'F' => 28,
            'G' => 28,
            'H' => 30,
            'I' => 12,
            'J' => 35,
            'K' => 28,
        ];
    }

    /**
     * Aplicar formato general después de generar la hoja.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Combinar celdas del encabezado.
                $sheet->mergeCells('A1:K1');
                $sheet->mergeCells('A2:B2');
                $sheet->mergeCells('C2:K2');
                $sheet->mergeCells('A3:B3');
                $sheet->mergeCells('C3:K3');
                $sheet->mergeCells('A4:K4');

                // Título principal.
                $sheet->getStyle('A1:K1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 15,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getRowDimension(1)->setRowHeight(28);

                // Responsable y cargo.
                foreach (['A2:B2', 'A3:B3'] as $rango) {
                    $sheet->getStyle($rango)->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'D6A84F'],
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);
                }

                $sheet->getStyle('C2:K3')->applyFromArray([
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);

                // Subtítulo.
                $sheet->getStyle('A4:K4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getRowDimension(4)->setRowHeight(23);
                $sheet->getRowDimension(5)->setRowHeight(30);

                // Bordes y formato de todas las celdas.
                $ultimaFila = $sheet->getHighestRow();

                $sheet->getStyle("A5:K{$ultimaFila}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_TOP,
                        'wrapText' => true,
                    ],
                ]);

                // Centrar los datos numéricos, fechas y estados.
                $sheet->getStyle("A6:C{$ultimaFila}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("I6:I{$ultimaFila}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Altura automática para facilitar la lectura.
                for ($fila = 6; $fila <= $ultimaFila; $fila++) {
                    $sheet->getRowDimension($fila)->setRowHeight(-1);
                }
            },
        ];
    }
}