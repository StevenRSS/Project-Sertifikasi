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
        Schema::create('category_list', function (Blueprint $table) {
            $table->id('category_list_id'); 
            $table->unsignedBigInteger('book_id')->index(); 
            $table->unsignedBigInteger('category_id')->index(); 
            $table->string('genre');
            $table->timestamps(); 

            // Foreign key constrainsts
            $table->foreign('book_id')->references('book_id')->on('book')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_list');
    }
};
