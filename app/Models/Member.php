<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    protected $fillable = [
        'name',
        'nim',
        'email',
        'photo',
        'linkedIn',
        'github',
        'instagram',
    ];

    public function getPhotoUrlAttribute()
    {
        return asset('storage/' . $this->photo);
    }
}
