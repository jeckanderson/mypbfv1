<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\Kabupaten;
use Laravolt\Indonesia\Models\Provinsi;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profile';
    protected $guarded = "id";

    public function getProvinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi', 'id');
    }

    public function getKabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten', 'id');
    }

    public function Ppn()
    {
        return $this->belongsTo(PPN::class, 'id', 'id_perusahaan');
    }
}