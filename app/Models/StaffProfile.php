<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaffProfile extends Model
{
    protected $fillable = [
        'user_id',
        'employee_code',
        'designation',
        'department_id',
        'sub_department_id',
        'joining_date',
        'profile_photo',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'joining_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Staff User
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Academic Assignments
    |--------------------------------------------------------------------------
    */

    public function assignments(): HasMany
    {
        return $this->hasMany(
            StaffAssignment::class,
            'staff_profile_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    public function permissions(): HasMany
    {
        return $this->hasMany(
            StaffPermission::class,
            'staff_profile_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Check Permission
    |--------------------------------------------------------------------------
    */

    public function hasPermission(
        string $permissionKey
    ): bool {
        $today = now()->toDateString();

        return $this->permissions()
            ->where(
                'permission_key',
                $permissionKey
            )
            ->where(
                'is_active',
                true
            )
            ->where(function ($query) use ($today) {

                $query
                    ->whereNull('start_date')
                    ->orWhereDate(
                        'start_date',
                        '<=',
                        $today
                    );

            })
            ->where(function ($query) use ($today) {

                $query
                    ->whereNull('end_date')
                    ->orWhereDate(
                        'end_date',
                        '>=',
                        $today
                    );

            })
            ->exists();
    }
}