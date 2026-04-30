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
    Schema::create('tests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('tenant_id');
        $table->foreignId('class_id');
        $table->foreignId('subject_id');

        $table->string('type'); // CA1, CA2, CA3
        $table->date('date');
        $table->time('time');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
