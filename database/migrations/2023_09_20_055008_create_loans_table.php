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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('temporary_code')->nullable();
            $table->string('loan_code')->unique()->nullable();
            $table->unsignedBigInteger('applied_user_id');
            $table->foreign('applied_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('processing_user_id')->nullable();
            $table->foreign('processing_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('offer_id');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->unsignedBigInteger('requested_amount');
            $table->unsignedBigInteger('loan_term');
            $table->unsignedBigInteger('quoted_amount');
            $table->json('others')->nullable();
            $table->json('personal_information')->nullable();
            $table->json('communication_address')->nullable();
            $table->json('permanent_address')->nullable();
            $table->json('work_information')->nullable();
            $table->json('upload_document')->nullable();
            $table->text('digital_signature');
            $table->enum('status', LOAN_STATUS)->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
