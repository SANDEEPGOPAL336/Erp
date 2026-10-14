<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseYearSemester extends Model
{
    protected $table = 'course_year_semesters';

    protected $fillable = [
        'course_year_id',
        'semester_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function courseYear(): BelongsTo
    {
        return $this->belongsTo(
            CourseYear::class,
            'course_year_id'
        );
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(
            Semester::class,
            'semester_id'
        );
    }
}