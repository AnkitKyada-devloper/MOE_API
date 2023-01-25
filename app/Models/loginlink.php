<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class loginlink extends Model
{
    use HasFactory;
    use HasApiTokens;
    protected $table = "register_users";
    protected $primaryKey = "id";
    protected $fillable = [
        
        'mail_link',
       
    ];

}
