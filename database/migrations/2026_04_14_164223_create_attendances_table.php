<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->string('term')->nullable();
            $table->string('session')->nullable();
            $table->integer('score')->nullable()->comment('Attendance score from 1-10');
            $table->string('rating')->nullable()->comment('Fair, Good, Very Good, Excellent');
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            // Prevent duplicate attendance for same student on same subject/term/session
            $table->unique(['student_id', 'subject_id', 'term', 'session'], 'unique_student_subject_attendance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};