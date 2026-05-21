<?php
// database/migrations/2026_05_21_000002_create_support_replies_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('support_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('support_tickets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('reply');
            $table->boolean('is_owner_reply')->default(false);
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            
            $table->index(['ticket_id', 'is_read']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('support_replies');
    }
};