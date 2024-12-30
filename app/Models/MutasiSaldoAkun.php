<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiSaldoAkun extends Model
{
    use HasFactory;

    protected $table = 'mutasi_saldo';
    protected $guarded = ['id'];
    public $casts = [
        'tgl_input' => 'date',
    ];

    public function akunPengirim()
    {
        return $this->hasOne(AkunAkutansi::class, 'id', 'akun_pengirim');
    }

    public function akunPenerima()
    {
        return $this->hasOne(AkunAkutansi::class, 'id', 'akun_penerima');
    }
}
