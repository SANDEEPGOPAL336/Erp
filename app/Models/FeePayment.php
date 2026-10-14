<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    protected $fillable = [
        'admission_application_id',
        'installment_no',
        'amount',
        'payment_mode',
        'transaction_id',
        'receipt_path',
        'status',
        'verified_by',
        'verified_at',
    ];
}