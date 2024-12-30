<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJurnalAkun extends Model
{
    use HasFactory;

    protected $table = 'detail_jurnal_akun';
    protected $guarded = ['id'];
    protected $casts = [
        'debet' => 'double',
        'kredit' => 'double',
    ];

    public function akun()
    {
        return $this->hasOne(AkunAkutansi::class, 'id', 'id_akun');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    public function jurnal()
    {
        return $this->hasOne(JurnalAkun::class, 'id', 'id_jurnal');
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
