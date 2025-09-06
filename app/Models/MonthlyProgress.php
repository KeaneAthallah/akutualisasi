<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyProgress extends Model
{
    protected $table = "monthly_progress";

    protected $fillable = [
        "kecamatan_id",
        "month",
        "year",
        "capaian_kbpp",
        "capaian_kbpp_percent",
        "capaian_mkjp",
        "capaian_mkjp_percent",
    ];

    /**
     * Get the kecamatan this monthly progress belongs to.
     *
     * @return BelongsTo<Kecamatan, MonthlyProgress>
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
