<?php

namespace App\Exports;

use App\Models\Kecamatan;
use Maatwebsite\Excel\Concerns\FromCollection;

class KecamatansExport implements FromCollection
{
    public function collection()
    {
        return Kecamatan::with("kabupaten")->get();
    }
}
