<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PdfDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'no_surat',
        'file_path',
    ];
}
