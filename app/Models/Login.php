<?php

namespace App\Models;
<<<<<<< HEAD

=======
// use Illuminate\Auth\Middleware\Authenticate;
>>>>>>> dbacf7c1959c68835a15309530302108eabb3af9
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
<<<<<<< HEAD
        'id',
        'email',
        'pin',
        'mail_link',
=======
     
        'email',
        'pin',
>>>>>>> dbacf7c1959c68835a15309530302108eabb3af9
        'is_twostep_active',
        'secret_key'
    ];

}
