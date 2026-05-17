<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('results', 'class_id')) {
            Schema::table('results', function (Blueprint $table) {
                $table->unsignedBigInteger('class_id')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('results', 'class_id')) {
            Schema::table('results', function (Blueprint $table) {
                $table->unsignedBigInteger('class_id')->nullable(false)->change();
            });
        }
    }
};