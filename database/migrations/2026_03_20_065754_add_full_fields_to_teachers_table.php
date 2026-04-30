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
    Schema::table('teachers', function (Blueprint $table) {

        // 🧑 BASIC INFO
        $table->string('name')->after('user_id');
        $table->string('email')->nullable()->after('name');
        $table->string('phone')->nullable()->after('email');
        $table->string('gender')->nullable()->after('phone');
        $table->date('dob')->nullable()->after('gender');
        $table->text('address')->nullable()->after('dob');

        // 🆔 EMPLOYMENT
        $table->string('staff_id')->unique()->after('employee_id');
        $table->date('employment_date')->nullable()->after('staff_id');
        $table->string('employment_type')->nullable()->after('employment_date');
        $table->string('position')->default('teacher')->after('department');
        $table->string('status')->default('active')->after('position');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('teachers', function (Blueprint $table) {
        $table->dropColumn([
            'name',
            'email',
            'phone',
            'gender',
            'dob',
            'address',
            'staff_id',
            'employment_date',
            'employment_type',
            'position',
            'status',
        ]);
    });
}
};
