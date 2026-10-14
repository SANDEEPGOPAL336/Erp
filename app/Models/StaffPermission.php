<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffPermission extends Model
{
    protected $fillable = [
        'staff_profile_id',
        'permission_key',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function staffProfile(): BelongsTo
    {
        return $this->belongsTo(
            StaffProfile::class,
            'staff_profile_id'
        );
    }

    public function isCurrentlyActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $today = now()->startOfDay();

        if (
            $this->start_date &&
            $today->lt(
                $this->start_date->startOfDay()
            )
        ) {
            return false;
        }

        if (
            $this->end_date &&
            $today->gt(
                $this->end_date->endOfDay()
            )
        ) {
            return false;
        }

        return true;
    }
}