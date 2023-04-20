<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('driving_students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('mobile_number');
            $table->string('student_address');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_passed')->default(0);
            $table->foreignId('driving_school_id')->nullable()->constrained('driving_schools');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driving_students');
    }
};
