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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->text('comment',255)->nullable();
            $table->integer('rate')->checkBetween(1,5)->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->Integer('likes_count')->default(0);
            $table->Integer('dislikes_count')->default(0);
=======
            $table->text('comment');
            $table->integer('rate');
            $table->boolean('like');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
