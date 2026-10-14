<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'program_group_id',
        'name',
        'code',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function programGroup(): BelongsTo
    {
        return $this->belongsTo(
            ProgramGroup::class,
            'program_group_id'
        );
    }

    public function subDepartments(): HasMany
    {
        return $this->hasMany(
            SubDepartment::class,
            'department_id'
        );
    }

    public function courses(): HasMany
    {
        return $this->hasMany(
            Course::class,
            'department_id'
        );
    }
}