<?php

namespace App\Models;

use App\Models\DetailJurnalAkun;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JurnalAkun extends Model
{
    use HasFactory;

    protected $table = 'jurnal_akun';
    protected $guarded = ['id'];
    public $casts = [
        'tgl_input' => 'date'
    ];

    /**
     * Get all of the detail_jurnal_akun for the JurnalAkun
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detail_jurnal_akun()
    {
        return $this->hasMany(DetailJurnalAkun::class,'id_ja');
    }
    /**
     * Get the detail_jurnal associated with the JurnalAkun
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detail_jurnal()
    {
        return $this->hasOne(DetailJurnalAkun::class, 'id_ja')->latest();
    }
}
