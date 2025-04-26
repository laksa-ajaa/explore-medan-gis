<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiWisata extends Model
{
    protected $table = 'lokasi_wisata';

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
