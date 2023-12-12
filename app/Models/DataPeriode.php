<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPeriode extends Model
{
    use HasFactory;
    protected $fillable = ['nama_periode','periode','status_periode'];
}
