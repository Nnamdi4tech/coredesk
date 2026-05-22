<?php
// database/migrations/2026_05_22_000001_modify_teachers_staff_id_unique_per_tenant.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First, drop the existing unique constraint on staff_id
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropUnique(['staff_id']);
            // Add composite unique constraint for tenant_id and staff_id
            $table->unique(['tenant_id', 'staff_id']);
        });
    }

    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropUnique(['tenant_id', 'staff_id']);
            $table->unique(['staff_id']);
        });
    }
};