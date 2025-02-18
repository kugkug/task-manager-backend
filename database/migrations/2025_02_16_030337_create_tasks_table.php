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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->dateTime('started_date')->nullable();
            $table->dateTime('completed_date')->nullable();
            $table->smallInteger('status')->nullable();
            $table->bigInteger('assigned_to')->constrained('users')->nullable();
            $table->bigInteger('created_by')->constrained('users');
            $table->bigInteger('approved_by')->constrained('users')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};