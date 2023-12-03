<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komponen extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_item',
        'id_satuan',
        'volume'
    ];

    public function item_kegiatan()
    {
        return $this->belongsTo(ItemKegiatan::class, 'id_item');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan');
    }
}
