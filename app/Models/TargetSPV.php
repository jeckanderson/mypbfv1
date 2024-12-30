<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetSPV extends Model
{
    use HasFactory;

    protected $table = 'target_spv';
    protected $guarded = 'id';

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'id', 'supervisor');
    }

    public function rayon()
    {
        return $this->hasOne(AreaRayon::class, 'id', 'area_rayon');
    }
}