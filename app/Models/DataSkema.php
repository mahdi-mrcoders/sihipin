<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSkema extends Model
{
    use HasFactory;
    protected $table = 'skemas';
    protected $fillable = ['nama_skema','status_skema','jumlah_anggota'];
}
