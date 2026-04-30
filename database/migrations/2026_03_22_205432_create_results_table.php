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
    Schema::create('results', function (Blueprint $table) {
        $table->id();

        // 🔗 MULTI TENANCY
        $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();

        // 🔗 RELATIONSHIPS
        $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
        $table->foreignId('student_id')->constrained()->cascadeOnDelete();
        $table->foreignId('subject_id')->constrained()->cascadeOnDelete();

        // 📝 SCORES
        $table->integer('ca1')->default(0);
        $table->integer('ca2')->default(0);
        $table->integer('ca3')->default(0);
        $table->integer('exam')->default(0);

        // 📊 CALCULATED
        $table->integer('total')->default(0);
        $table->decimal('average', 5, 2)->default(0);

        // 🎓 OUTPUT
        $table->string('grade')->nullable();
        $table->string('remark')->nullable();
        $table->integer('position')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
