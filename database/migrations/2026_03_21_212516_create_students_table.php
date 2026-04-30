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
        Schema::create('students', function (Blueprint $table) {
    $table->id();

    // 🔗 MULTI TENANCY
    $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();

    // 🔗 TEACHER (VERY IMPORTANT)
    $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();

    // 🧑 STUDENT INFO
    $table->string('name');
    $table->string('email')->nullable();
    $table->string('phone')->nullable();
    $table->string('gender')->nullable();

    // 🏫 SCHOOL INFO
    $table->string('class')->nullable(); // JSS1, SS2
    $table->string('student_id')->unique();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
