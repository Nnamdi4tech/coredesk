<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Remove the existing unique index on email
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
        });
        
        // Add composite unique index on email and tenant_id
        Schema::table('users', function (Blueprint $table) {
            $table->unique(['email', 'tenant_id']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_tenant_id_unique');
            $table->unique('email');
        });
    }
};