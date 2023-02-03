<?php

namespace App\Models;


use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'mail_link',
        'is_twostep_active',
        'secret_key',
        'pin_expires_time'
    ];

}
