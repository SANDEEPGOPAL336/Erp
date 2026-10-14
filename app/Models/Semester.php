<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = [
        'name',
        'semester_number',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'semester_number' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}