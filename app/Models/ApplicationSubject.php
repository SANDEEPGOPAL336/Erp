<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationSubject extends Model
{
    protected $fillable = [
        'admission_application_id',
        'subject_id',
        'position',
    ];
}