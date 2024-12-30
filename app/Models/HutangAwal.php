<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HutangAwal extends Model
{
    use HasFactory;
    protected $table = 'hutang_awals';
    protected $guarded = ['id'];
    public $casts = [
        'tgl_faktur' => 'date',
    ];
    public $appends = [
        'tempo_kredit','total_tagihan'
    ];
    public function getSuplier()
    {
        return $this->hasOne(Suplier::class, 'id', 'supplier');
    }

    function hutang_pengguna(){
        return $this->morphMany(HutangPengguna::class,'sourceable');
    }
    public function getTempoKreditAttribute(){
        return Carbon::parse($this->tgl_jth_tempo);
    }
    public function getTotalTagihanAttribute(){
        return $this->jmlh_hutang;
    }
    public function getAkunAttribute(){
        return null;
    }
}
