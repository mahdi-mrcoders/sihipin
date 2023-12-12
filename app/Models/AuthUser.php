<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthUser extends Model
{
    use HasFactory;

    protected $table = 'auths';
    protected $primaryKey = 'id_pengguna';
    protected $fillable =[
        'email_dosen','username','password','level'
    ];
}
