<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyProgress extends Model
{
    use HasFactory;
    protected $table = "monthly_progress";

    protected $guarded = ["id"];

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
