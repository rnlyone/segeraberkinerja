<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_renstra',
        'kode',
        'nama_program',
        'jenis_program',
        'dokumen',
    ];

    public function renstra()
    {
        return $this->belongsTo(Renstra::class, 'id_renstra');
    }

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'id_program');
    }


}
