<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentQualification extends Model
{
    protected $fillable = [
        'student_profile_id',
        'qualification_name',
        'subjects_stream',
        'university_board',
        'board_roll_no',
        'school_institute',
        'result_type',
        'passing_year',
        'obtained_marks',
        'total_marks',
        'percentage',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'passing_year' => 'integer',
            'obtained_marks' => 'decimal:2',
            'total_marks' => 'decimal:2',
            'percentage' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}