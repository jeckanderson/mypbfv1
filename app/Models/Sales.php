<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $guarded = 'id';

    public function pegawai_sales()
    {
        return $this->hasOne(Pegawai::class, 'id', 'sales');
    }

    public function pegawai_supervisor()
    {
        return $this->hasOne(Pegawai::class, 'id', 'supervisor');
    }

    public function rayon()
    {
        return $this->hasOne(AreaRayon::class, 'id', 'area_rayon');
    }

    public function subRayon()
    {
        return $this->hasOne(SubRayon::class, 'id', 'sub_rayon');
    }

    public function sub()
    {
        return $this->hasOne(SubRayon::class, 'id', 'sub_rayon');
    }
}
