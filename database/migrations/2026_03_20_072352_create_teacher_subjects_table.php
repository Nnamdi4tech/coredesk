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
    Schema::create('teacher_subjects', function (Blueprint $table) {
        $table->id();

        // 🔗 MULTI TENANCY
        $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();

        // 🔗 RELATIONS
        $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
        $table->foreignId('subject_id')->constrained()->cascadeOnDelete();

        // (we will add class_id later)
        // $table->foreignId('class_id')->nullable()->constrained()->cascadeOnDelete();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('teacher_subjects');
}


};
