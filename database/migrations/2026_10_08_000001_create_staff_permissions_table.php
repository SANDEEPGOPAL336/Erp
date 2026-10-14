<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('staff_permissions')) {

            Schema::create(
                'staff_permissions',
                function (Blueprint $table) {

                    $table->id();

                    $table->foreignId(
                        'staff_profile_id'
                    )
                    ->constrained(
                        'staff_profiles'
                    )
                    ->cascadeOnDelete();

                    $table->string(
                        'permission_key',
                        100
                    );

                    $table->date(
                        'start_date'
                    )->nullable();

                    $table->date(
                        'end_date'
                    )->nullable();

                    $table->boolean(
                        'is_active'
                    )->default(true);

                    $table->timestamps();

                    $table->unique(
                        [
                            'staff_profile_id',
                            'permission_key'
                        ],
                        'staff_permissions_staff_key_unique'
                    );

                    $table->index(
                        [
                            'permission_key',
                            'is_active'
                        ],
                        'staff_permissions_key_active_index'
                    );
                }
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'staff_permissions'
        );
    }
};