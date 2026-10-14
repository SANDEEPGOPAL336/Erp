<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Student Profile
    |--------------------------------------------------------------------------
    */

    public function studentProfile(): HasOne
    {
        return $this->hasOne(
            StudentProfile::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Staff Profile
    |--------------------------------------------------------------------------
    */

    public function staffProfile(): HasOne
    {
        return $this->hasOne(
            StaffProfile::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Admission Applications
    |--------------------------------------------------------------------------
    */

    public function admissionApplications(): HasMany
    {
        return $this->hasMany(
            AdmissionApplication::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Student Enrollments
    |--------------------------------------------------------------------------
    */

    public function enrollments(): HasMany
    {
        return $this->hasMany(
            StudentEnrollment::class,
            'user_id'
        );
    }
}