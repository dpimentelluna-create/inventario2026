<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EquiposExport implements WithMultipleSheets
{
    protected Collection $equipos;

    public function __construct(Collection $equipos)
    {
        $this->equipos = $equipos;
    }

    public function sheets(): array
    {
        return [
            new EquiposCompletoSheet($this->equipos),
            new EquiposInformacionGeneralSheet($this->equipos),
            new EquiposDetallesSheet($this->equipos),
            new EquiposAccesoriosSheet($this->equipos),
        ];
    }
}