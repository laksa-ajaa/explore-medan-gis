<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineJalur extends Model
{
    protected $table = 'line_jalurs';
    protected $fillable = [
        'start_id',
        'wisata_id',
        'geom'
    ];
}
