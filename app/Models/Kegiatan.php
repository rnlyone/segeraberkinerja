<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_program',
        'tahun',
        'kode',
        'nama_kegiatan',
        'pagu_anggaran',
        'pagu_indikatif',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }

    public function itemKegiatans()
    {
        return $this->hasMany(ItemKegiatan::class, 'id_kegiatan');
    }


}
