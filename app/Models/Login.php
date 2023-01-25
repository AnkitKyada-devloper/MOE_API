<?php

namespace App\Models;

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
        'id',
        'email',
        'pin',
        'mail_link',
        'is_twostep_active',
        'secret_key'
    ];

}
