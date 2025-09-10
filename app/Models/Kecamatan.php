<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    /**
     * Get the kabupaten that owns this kecamatan.
     *
     * @return BelongsTo<Kabupaten, Kecamatan>
     */
    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class);
    }

    /**
     * Get the targets for this kecamatan.
     *
     * @return HasMany<Target>
     */
    public function targets(): HasMany
    {
        return $this->hasMany(Target::class);
    }

    /**
     * Get the monthly progress for this kecamatan.
     *
     * @return HasMany<MonthlyProgress>
     */
    public function monthlyProgress(): HasMany
    {
        return $this->hasMany(MonthlyProgress::class);
    }
}
