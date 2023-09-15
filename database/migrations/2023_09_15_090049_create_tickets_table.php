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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requested_by');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('assign_to');
            $table->foreign('assign_to')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->foreign('closed_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->enum('priority', TASK_PRIORITY)->default('low');
            $table->string('status')->nullable();
            $table->longText('issue');
            $table->longText('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
