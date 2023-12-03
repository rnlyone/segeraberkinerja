<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKPD extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama_skpd',
        'foto_skpd',
        'level_otoritas',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_skpd');
    }

    public function renstras()
    {
        return $this->hasMany(Renstra::class, 'id_skpd');
    }

}
