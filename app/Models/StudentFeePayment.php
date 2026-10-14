<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentFeePayment extends Model
{
    protected $fillable = [
        'admission_application_id',
        'student_enrollment_id',
        'installment_number',
        'amount_paid',
        'payment_mode',
        'receipt_number',
        'payment_date',
        'status',
        'verified_by',
        'verified_at',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'installment_number' => 'integer',
            'amount_paid' => 'decimal:2',
            'payment_date' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    public function admissionApplication(): BelongsTo
    {
        return $this->belongsTo(
            AdmissionApplication::class,
            'admission_application_id'
        );
    }

    public function studentEnrollment(): BelongsTo
    {
        return $this->belongsTo(
            StudentEnrollment::class,
            'student_enrollment_id'
        );
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'verified_by'
        );
    }
}
