<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->enum('type', ['note','link','file','expense']);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('expense_amount')->nullable();
            $table->string('file_path')->nullable();
            $table->foreignId('added_by')->constrained('user')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adds');
    }
};
