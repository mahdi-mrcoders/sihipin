<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSyarat extends Model
{
    use HasFactory;
    protected $table = 'syarats';
    protected $fillable = ['id_skema','persyaratan'];
}
