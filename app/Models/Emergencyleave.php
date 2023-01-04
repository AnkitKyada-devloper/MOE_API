<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emergencyleave extends Model
{
    use HasFactory;

    protected $table = "emergencyleave";
    protected $primarykey = "id";
    protected $fillable = [
        'leave_type',
        'reason',
        'start_date',
        'end_date',
        'upload_document'
];

}
