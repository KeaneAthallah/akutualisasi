<?php

namespace App\Exports;

use App\Models\Kabupaten;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class KabupatensExport implements FromCollection
{
    public function collection(): Collection
    {
        return Kabupaten::all();
    }
}
