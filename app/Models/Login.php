<?php

namespace App\Models;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Login extends Authenticatable
{
    use HasFactory;
    use HasApiTokens; 


    protected $table = "register_users";
    protected $primaryKey = "id";
    protected $fillable = [
     
        'email',
        'pin',
        'is_twostep_active',
        'secret_key'
    ];

}
