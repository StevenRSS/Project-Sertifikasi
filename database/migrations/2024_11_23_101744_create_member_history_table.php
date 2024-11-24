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
        Schema::create('member_history', function (Blueprint $table) {
            $table->id('borrow_id');
            $table->unsignedBigInteger('member_id')->index();
            $table->unsignedBigInteger('book_id')->index();
            $table->date('due_date');
            $table->date('returned_at')->nullable();
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('member_id')->references('member_id')->on('member')->onDelete('cascade');
            $table->foreign('book_id')->references('book_id')->on('book')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_history');
    }
};
