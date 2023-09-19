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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_type_id');
            $table->foreign('offer_type_id')->references('id')->on('offer_types')->onDelete('cascade');
            $table->unsignedBigInteger('offer_category_id');
            $table->foreign('offer_category_id')->references('id')->on('offer_categories')->onDelete('cascade');
            $table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
            $table->date('starting_date')->nullable();
            $table->date('ending_date')->nullable();
            $table->integer('min_cibil')->nullable();
            $table->integer('max_cibil')->nullable();
            $table->string('offer_title')->nullable();
            $table->string('secondary_title')->nullable();
            $table->text('offer_banner')->nullable();
            $table->text('offer_description')->nullable();
            $table->text('offer_terms')->nullable();
            $table->json('feature_list')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
