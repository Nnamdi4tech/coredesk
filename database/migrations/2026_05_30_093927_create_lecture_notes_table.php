<?php
// database/migrations/2026_05_30_000001_create_lecture_notes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lecture_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->string('title', 255);
            $table->text('content');
            $table->string('file_path')->nullable(); // For PDF, DOC, etc.
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable();
            $table->enum('type', ['text', 'file'])->default('text');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('approved')->default(false);
            $table->boolean('rejected')->default(false);
            $table->text('rejection_reason')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            
            $table->index(['tenant_id', 'class_id', 'subject_id']);
            $table->index(['tenant_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('lecture_notes');
    }
};