<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Target extends Model
{
    protected $fillable = [
        "kecamatan_id",
        "year",
        "target_kbpp",
        "capaian_kbpp",
        "capaian_kbpp_percent",
        "target_mkjp",
        "capaian_mkjp",
        "capaian_mkjp_percent",
    ];

    /**
     * Get the kecamatan this target belongs to.
     *
     * @return BelongsTo<Kecamatan, Target>
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
