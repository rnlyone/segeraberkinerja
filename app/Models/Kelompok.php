<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'uraian'
    ];

    public function satuans()
    {
        return $this->hasMany(Satuan::class, 'id_kelompok');
    }
}
