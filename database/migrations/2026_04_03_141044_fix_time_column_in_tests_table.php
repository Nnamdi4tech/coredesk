<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixTimeColumnInTestsTable extends Migration
{
    public function up()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->time('time')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->time('time')->nullable(false)->change();
        });
    }
}