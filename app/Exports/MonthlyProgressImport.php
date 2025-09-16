<?php

namespace App\Exports;

use App\Models\MonthlyProgress;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MonthlyProgressImport implements ToModel, WithHeadingRow
{
  protected $kecamatanId;

  public function __construct($kecamatanId)
  {
    $this->kecamatanId = $kecamatanId;
  }

  public function model(array $row)
  {
    return MonthlyProgress::updateOrCreate(
      [
        'kecamatan_id' => $this->kecamatanId,
        'month' => $row['month'],
      ],
      [
        'capaian_kbpp' => $row['capaian_kbpp'],
        'capaian_mkjp' => $row['capaian_mkjp'],
      ]
    );
  }
}
