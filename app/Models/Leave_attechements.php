<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Auth;

class Leave_attechements extends Model
{
    use HasFactory;
    protected $table = "leave_attechements";
    protected $primaryKey = "id";
    protected $fillable = [
        'leave_id',
        'attechement_type_id',
        'upload_document ',
       ];
}
