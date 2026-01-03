<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'text_hash',
        'original_text',
        'translated_text',
        'source_lang',
        'target_lang',
    ];
}
