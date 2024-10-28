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
        Schema::create('book_user', function (Blueprint $table) {
            $table->unsignedBigInteger("book_id");
            $table->unsignedBigInteger("user_id");
            $table->dateTime("date_borrowed")->useCurrent();
            $table->dateTime("date_returned")->nullable();

            $table->primary(["book_id", "user_id"]);

            $table->foreign("book_id")->references("id")->on("books");
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_user');
    }
};
