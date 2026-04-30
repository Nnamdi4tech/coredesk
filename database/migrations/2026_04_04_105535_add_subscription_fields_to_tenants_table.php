<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionFieldsToTenantsTable extends Migration
{
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->timestamp('starts_at')->nullable()->after('plan');
            $table->timestamp('expires_at')->nullable()->after('starts_at');
            $table->boolean('is_active')->default(true)->after('expires_at');
        });
    }

    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['starts_at', 'expires_at', 'is_active']);
        });
    }
};
