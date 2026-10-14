<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'admission_application_id',
        'college_no',
        'roll_no',
        'enrolled_at',
    ];
}