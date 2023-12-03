<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renstra extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_skpd',
        'periode',
        'visi',
        'misi',
        'tujuan',
        'sasaran',
        'dokumen',
    ];

    public function skpd()
    {
        return $this->belongsTo(SKPD::class, 'id_skpd');
    }

    public function programs()
    {
        return $this->hasMany(Program::class, 'id_renstra');
    }


}
