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

class AccesoriosSinEquiposSheet implements FromCollection, WithEvents, WithStyles, WithColumnWidths, WithTitle
{
    protected Collection $equipos;

    public function title(): string
    {
        return 'ACCESORIOS SIN EQUIPOS';
    }

    public function __construct(Collection $equipos)
    {
        $this->equipos = $equipos;
    }

    public function collection()
    {
        $filas = collect();

        // Espacio para encabezado (igual que las otras hojas)
        for ($i = 1; $i <= 5; $i++) {
            $filas->push(array_fill(0, 7, ''));
        }

        $filas->push([
            'N°',
            'TIPO',
            'MARCA',
            'NÚM. SERIE',
            'ESTADO',
            'UBICACIÓN',
            'OBSERVACIONES',
        ]);

        $ubicacionIds = $this->equipos
            ->pluck('ubicacion_id')
            ->filter()
            ->unique()
            ->values();

        $query = AccesoriosEquipo::query()
            ->whereNull('equipo_id')
            ->with('ubicacion');

        if ($ubicacionIds->isEmpty()) {
            $query->whereRaw('1 = 0');
        } else {
            $query->whereIn('ubicacion_id', $ubicacionIds);
        }

        $accesorios = $query->orderBy('tipo')->orderBy('marca')->get();

        $indice = 1;
        foreach ($accesorios as $accesorio) {
            $filas->push([
                sprintf('%02d', $indice),
                strtoupper($accesorio->tipo ?? '-'),
                strtoupper($accesorio->marca ?? '-'),
                strtoupper($accesorio->num_serie ?? '-'),
                strtoupper($accesorio->estado ?? '-'),
                strtoupper($accesorio->ubicacion->nombre ?? 'SIN UBICACIÓN'),
                strtoupper($accesorio->observaciones ?? '-'),
            ]);
            $indice++;
        }

        if ($accesorios->isEmpty()) {
            $filas->push([
                '', '', '', '', '', '',
                'NO HAY ACCESORIOS INDEPENDIENTES EN LAS UBICACIONES FILTRADAS'
            ]);
        }

        return $filas;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 20,
            'C' => 20,
            'D' => 35,
            'E' => 15,
            'F' => 25,
            'G' => 40,
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

                // ========== TÍTULO ==========
                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', 'FORMATO PARA REGISTRO DE EQUIPOS TECNOLOGICOS');
                $sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(22);

                // ========== ENCABEZADO (RESPONSABLE / UBICACIÓN / etc.) ==========
                $ubicaciones = $this->equipos
                    ->map(fn ($equipo) => mb_strtoupper(trim($equipo->ubicacione->nombre ?? '')))
                    ->filter()
                    ->unique();

                $ubicacionReporte = $ubicaciones->count() === 1
                    ? $ubicaciones->first()
                    : ($ubicaciones->count() ? 'VARIAS' : '-');

                $fechaReporte = now()->format('d-m-Y');

                $sheet->setCellValue('B2', 'RESPONSABLE');
                $sheet->mergeCells('C2:D2');
                $sheet->setCellValue('C2', 'ING. MICHAEL CABOS OLIVARES');
                $sheet->setCellValue('E2', 'UBICACIÓN');
                $sheet->mergeCells('F2:G2');
                $sheet->setCellValue('F2', $ubicacionReporte);

                $sheet->setCellValue('B3', 'CARGO');
                $sheet->mergeCells('C3:D3');
                $sheet->setCellValue('C3', 'COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO');
                $sheet->setCellValue('E3', 'FECHA');
                $sheet->mergeCells('F3:G3');
                $sheet->setCellValue('F3', $fechaReporte);

                foreach (['B2:D2', 'E2:G2', 'B3:D3', 'E3:G3'] as $rango) {
                    $sheet->getStyle($rango)->applyFromArray([
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);
                }

                foreach (['B2', 'E2', 'B3', 'E3'] as $celda) {
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

                // ========== SUBTÍTULO ==========
                $sheet->mergeCells('A5:G5');
                $sheet->setCellValue('A5', 'ACCESORIOS SIN EQUIPOS RELACIONADOS');
                $sheet->getStyle('A5:G5')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // ========== ENCABEZADOS DE TABLA ==========
                $headers = [
                    'A6' => 'N°',
                    'B6' => 'TIPO',
                    'C6' => 'MARCA',
                    'D6' => 'NÚM. SERIE',
                    'E6' => 'ESTADO',
                    'F6' => 'UBICACIÓN',
                    'G6' => 'OBSERVACIONES',
                ];

                foreach ($headers as $celda => $valor) {
                    $sheet->setCellValue($celda, $valor);
                }

                $sheet->getStyle('A6:G6')->applyFromArray([
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

                // ========== ESTILO DE DATOS ==========
                $highestRow = $sheet->getHighestRow();
                if ($highestRow >= 7) {
                    $sheet->getStyle('A7:G' . $highestRow)->applyFromArray([
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

                    $sheet->getStyle('E7:E' . $highestRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    $sheet->setAutoFilter('A6:G' . $highestRow);
                }
            },
        ];
    }
}