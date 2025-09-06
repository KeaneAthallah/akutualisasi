<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kabupaten extends Model
{
    protected $fillable = ["name"];

    /**
     * Get the kecamatans for this kabupaten.
     *
     * @return HasMany<Kecamatan>
     */
    public function kecamatans(): HasMany
    {
        return $this->hasMany(Kecamatan::class);
    }
}
