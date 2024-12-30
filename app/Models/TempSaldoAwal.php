<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempSaldoAwal extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'temp_saldo_awal';

    public function akun()
    {
        return $this->hasOne(AkunAkutansi::class, 'id', 'id_akun');
    }
}
