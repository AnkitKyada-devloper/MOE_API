<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Auth;


class Emergencyleave extends Model
{
    use HasFactory;
   

    protected $table = "emergencyleaves";
    protected $primaryKey = "id";
    protected $fillable = [
        'register_user_id',
        'leave_type_id',
        'leave_type',
        'reason',
        'fromDate1',
        'toDate1',
        'totalNoOfDays',
        'pendingLeaves',
        'paidLeaves',
        'lost_of_pay'
];

}
