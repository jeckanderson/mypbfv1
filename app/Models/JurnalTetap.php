<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalTetap extends Model
{
    use HasFactory;

    protected $table = 'jurnal_tetap';
    protected $guarded = ['id'];

    public function akunAkutansi()
    {
        return $this->belongsTo(AkunAkutansi::class, 'id_akun');
    }
}