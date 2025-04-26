<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitikStart extends Model
{
    protected $table = 'titik_starts';

    protected $fillable = [
        'name',
        'desc',
        'category',
    ];
}
