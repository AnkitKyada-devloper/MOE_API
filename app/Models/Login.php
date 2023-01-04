<?php

namespace App\Models;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Login extends Model
{
    use HasFactory;
    use HasApiTokens;


    protected $table = "login";
    protected $primarykey = "id";
    protected $fillable = [
        'email',
        'pin'
    ];

}
