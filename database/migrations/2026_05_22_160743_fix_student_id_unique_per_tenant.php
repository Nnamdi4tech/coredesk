<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('students', function (Blueprint $table) {
        $table->dropUnique(['student_id']);
        $table->unique(['tenant_id', 'student_id']);
    });
}

public function down()
{
    Schema::table('students', function (Blueprint $table) {
        $table->dropUnique(['tenant_id', 'student_id']);
        $table->unique(['student_id']);
    });
}
};
