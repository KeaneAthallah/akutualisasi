<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PergerakanKbpp extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan',
        'waktu_pelaksanaan',
        'tempat',
        'link'
    ];

    protected $casts = [
        'waktu_pelaksanaan' => 'datetime'
    ];

    /**
     * Get formatted waktu pelaksanaan
     */
    public function getFormattedWaktuAttribute()
    {
        return $this->waktu_pelaksanaan->format('d/m/Y H:i');
    }

    /**
     * Get formatted waktu for form input
     */
    public function getFormattedWaktuInputAttribute()
    {
        return $this->waktu_pelaksanaan->format('Y-m-d\TH:i');
    }
}
