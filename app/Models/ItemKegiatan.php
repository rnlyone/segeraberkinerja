<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemKegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama_sub',
        'kinerja',
        'indikator',
        'satuan',
        'pagu_indikatif',
        'pagu_anggaran',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan');
    }

    public function komponens()
    {
        return $this->hasMany(Komponen::class, 'id_item');
    }

}
