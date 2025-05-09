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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("title");

            $table->unsignedBigInteger("author_id");
            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("publisher_id");

            
            $table->foreign("author_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("category_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("publisher_id")->references("id")->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
