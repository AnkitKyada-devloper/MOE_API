<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Emergencyleave extends Authenticatable
{
    use HasFactory;
   use HasApiTokens;

    protected $table = "emergencyleaves";
    protected $primaryKey = "id";
    protected $fillable = [
        'register_user_id',
        'leave_type_id',
        'reason',
        'fromDate1',
        'toDate1',
        'totalNoOfDays',
        'pendingLeaves',
        'paidLeaves',
        'lost_of_pay'
];

}
