<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Leave_attechements extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;

    protected $table = "leave_attechements";
    protected $primaryKey = "id";
    protected $fillable = [
        // 'leave_id',
        'attechement_type_id',
        'upload_document ',
        'location_latitude',
        'location_longitude'
       ];
}
