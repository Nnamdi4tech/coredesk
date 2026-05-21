<?php
// database/migrations/2026_05_21_000004_create_announcement_reads_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('announcement_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')->constrained('general_announcements')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->timestamp('read_at')->useCurrent();
            
            $table->unique(['announcement_id', 'tenant_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('announcement_reads');
    }
};