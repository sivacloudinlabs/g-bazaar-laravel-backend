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
        Schema::create('offer_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_type_id');
            $table->foreign('offer_type_id')->references('id')->on('offer_types')->onDelete('cascade');
            $table->string('name')->unique();
            $table->text('category_image')->nullable();
            $table->text('selected_category_image')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_categories');
    }
};
