<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetSales extends Model
{
    use HasFactory;
    protected $table = 'target_sales';
    protected $guarded = 'id';

    public function getSales()
    {
        return $this->belongsTo(Pegawai::class, 'sales');
    }

    public function getSupervisor()
    {
        return $this->belongsTo(Pegawai::class, 'supervisor');
    }

    public function rayon()
    {
        return $this->belongsTo(AreaRayon::class, 'area_rayon');
    }

    public function subRayon()
    {
        return $this->belongsTo(SubRayon::class, 'sub_rayon');
    }
}