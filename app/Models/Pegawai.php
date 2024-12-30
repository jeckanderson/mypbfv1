<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $guarded = 'id';
    public function sales()
    {
        return $this->hasMany(Sales::class, 'id', 'sales')->first();
    }
}
