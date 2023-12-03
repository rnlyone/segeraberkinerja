<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kelompok',
        'jenis_satuan',
        'kode',
        'nama_item',
        'spesifikasi',
        'satuan',
        'harga',
        'kode_rekening',
    ];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'id_kelompok');
    }
}
