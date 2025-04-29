<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointWisata extends Model
{
    protected $table = 'point_wisata';

    protected $casts = [
        'geom' => 'geometry',
    ];

    // protected $fillable = [
    //     'nama',
    //     'deskripsi',
    //     'alamat',
    //     'latitude',
    //     'longitude',
    //     'gambar',
    // ];
}
