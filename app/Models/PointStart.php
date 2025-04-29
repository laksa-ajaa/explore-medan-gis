<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointStart extends Model
{
    protected $table = 'point_start';

    protected $fillable = [
        'name',
        'desc',
        'category',
    ];
}
