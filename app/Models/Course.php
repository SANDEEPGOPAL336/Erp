<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'department_id',
        'sub_department_id',
        'name',
        'code',
        'duration',
        'study_pattern',
        'total_years',
        'admission_fee',
        'annual_fee',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'admission_fee' => 'decimal:2',
            'annual_fee' => 'decimal:2',
            'total_years' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(
            Department::class,
            'department_id'
        );
    }

    public function subDepartment(): BelongsTo
    {
        return $this->belongsTo(
            SubDepartment::class,
            'sub_department_id'
        );
    }

    public function years(): HasMany
    {
        return $this->hasMany(
            CourseYear::class,
            'course_id'
        )->orderBy('sort_order');
    }
}