<?php

namespace App\Exports;

use App\Models\Kecamatan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KecamatanImport implements ToModel, WithHeadingRow
{
  protected $kabupatenId;

  public function __construct($kabupatenId)
  {
    $this->kabupatenId = $kabupatenId;
  }

  public function model(array $row)
  {
    return Kecamatan::updateOrCreate(
      [
        'name' => $row['name'],
        'year' => $row['year'],
        'kabupaten_id' => $this->kabupatenId,
      ],
      [
        'target_kbpp' => $row['target_kbpp'],
        'target_mkjp' => $row['target_mkjp'],
      ]
    );
  }
}
