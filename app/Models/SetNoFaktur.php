<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetNoFaktur extends Model
{
    use HasFactory;

    protected $table = 'set_no_faktur';
    protected $guarded = ['id'];
}
