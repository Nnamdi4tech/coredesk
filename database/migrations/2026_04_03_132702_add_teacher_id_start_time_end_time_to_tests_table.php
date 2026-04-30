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
        Schema::table('tests', function (Blueprint $table) {
            // Add teacher_id as foreign key
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('set null');
            
            // Add start_time and end_time as time fields
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['teacher_id']);
            
            // Drop columns
            $table->dropColumn('teacher_id');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
        });
    }
};