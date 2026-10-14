<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentPromotion extends Model
{
    protected $fillable = [
        'student_enrollment_id',

        'from_session_id',
        'from_year_number',
        'from_semester_id',

        'to_session_id',
        'to_year_number',
        'to_semester_id',

        'promoted_at',
        'status',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'from_year_number' => 'integer',
            'to_year_number' => 'integer',
            'promoted_at' => 'date',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Enrollment
    |--------------------------------------------------------------------------
    */

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(
            StudentEnrollment::class,
            'student_enrollment_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | From Session
    |--------------------------------------------------------------------------
    */

    public function fromSession(): BelongsTo
    {
        return $this->belongsTo(
            AcademicSession::class,
            'from_session_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | From Semester
    |--------------------------------------------------------------------------
    */

    public function fromSemester(): BelongsTo
    {
        return $this->belongsTo(
            Semester::class,
            'from_semester_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | To Session
    |--------------------------------------------------------------------------
    */

    public function toSession(): BelongsTo
    {
        return $this->belongsTo(
            AcademicSession::class,
            'to_session_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | To Semester
    |--------------------------------------------------------------------------
    */

    public function toSemester(): BelongsTo
    {
        return $this->belongsTo(
            Semester::class,
            'to_semester_id'
        );
    }
}