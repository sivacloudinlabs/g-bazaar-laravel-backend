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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('date_of_birth')->nullable();
            $table->string('pan_card_number')->nullable();
            $table->unsignedBigInteger('aadhar_card_number')->nullable();
            $table->string('occupation_type')->nullable();
            $table->string('organization_name')->nullable();
            $table->double('monthly_income')->nullable();
            $table->string('area')->nullable();
            $table->string('landmark')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->unsignedBigInteger('pincode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
