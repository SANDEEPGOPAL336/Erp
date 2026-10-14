<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentEnrollment extends Model
{
    protected $fillable = [
        'user_id',
        'admission_application_id',
        'course_id',
        'academic_session_id',
        'year_number',
        'current_semester_id',
        'college_number',
        'roll_number',
        'enrollment_status',
        'enrollment_date',
        'completion_date',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'year_number' => 'integer',
            'enrollment_date' => 'date',
            'completion_date' => 'date',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Student
    |--------------------------------------------------------------------------
    */

    public function student(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Admission Application
    |--------------------------------------------------------------------------
    */

    public function admissionApplication(): BelongsTo
    {
        return $this->belongsTo(
            AdmissionApplication::class,
            'admission_application_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Programme
    |--------------------------------------------------------------------------
    */

    public function course(): BelongsTo
    {
        return $this->belongsTo(
            Course::class,
            'course_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Academic Session
    |--------------------------------------------------------------------------
    */

    public function academicSession(): BelongsTo
    {
        return $this->belongsTo(
            AcademicSession::class,
            'academic_session_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Current Semester
    |--------------------------------------------------------------------------
    */

    public function currentSemester(): BelongsTo
    {
        return $this->belongsTo(
            Semester::class,
            'current_semester_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Promotion History
    |--------------------------------------------------------------------------
    */

    public function promotions(): HasMany
    {
        return $this->hasMany(
            StudentPromotion::class,
            'student_enrollment_id'
        )->orderByDesc('promoted_at');
    }
}