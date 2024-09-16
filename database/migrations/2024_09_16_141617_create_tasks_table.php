<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('project')->onDelete('cascade');
            $table->string('task');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progres', 'completed', 'on_hold'])->default('pending');
            $table->foreignId('assigned_to')->nullable()->constrained('user')->onDelete('set null');
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
