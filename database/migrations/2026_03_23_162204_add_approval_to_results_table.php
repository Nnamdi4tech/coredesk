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
    Schema::table('results', function (Blueprint $table) {
        $table->boolean('approved')->default(false)->after('submitted');
        $table->boolean('rejected')->default(false)->after('approved');
    });
}

public function down(): void
{
    Schema::table('results', function (Blueprint $table) {
        $table->dropColumn(['approved', 'rejected']);
    });
}
};
