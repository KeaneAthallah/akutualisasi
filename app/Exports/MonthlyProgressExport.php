<?php

namespace App\Exports;

use App\Models\MonthlyProgress;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

class MonthlyProgressExport implements FromCollection
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection(): Collection
    {
        $query = MonthlyProgress::with(["kecamatan.kabupaten"]);

        if ($this->request->kabupaten_id) {
            $query->whereHas("kecamatan", function ($q) {
                $q->where("kabupaten_id", $this->request->kabupaten_id);
            });
        }

        if ($this->request->kecamatan_id) {
            $query->where("kecamatan_id", $this->request->kecamatan_id);
        }

        return $query->get();
    }
}
