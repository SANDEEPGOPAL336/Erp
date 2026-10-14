<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('student_fee_payments')) {
            return;
        }

        Schema::create('student_fee_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('admission_application_id')
                ->constrained('admission_applications')
                ->cascadeOnDelete();

            $table->foreignId('student_enrollment_id')
                ->nullable()
                ->constrained('student_enrollments')
                ->nullOnDelete();

            $table->unsignedTinyInteger('installment_number')->default(1);
            $table->decimal('amount_paid', 12, 2);
            $table->string('payment_mode', 30)->nullable();
            $table->string('receipt_number', 100)->nullable();
            $table->date('payment_date')->nullable();
            $table->string('status', 30)->default('verified');

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('verified_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique([
                'admission_application_id',
                'installment_number',
            ], 'student_fee_application_installment_unique');

            $table->index([
                'status',
                'installment_number',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_fee_payments');
    }
};
