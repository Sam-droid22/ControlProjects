<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaction_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // ingreso, gasto
            $table->string('nature'); // fijo, variable
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaction_categories');
    }
};