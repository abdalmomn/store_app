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
        Schema::create('trade_centers', function (Blueprint $table) {
            $table->id('id');
<<<<<<< HEAD
            $table->string('product_name');
            $table->integer('memory');
            $table->integer('battery_percentage');
            $table->string('brand_name');
            $table->date('date_of_manufacture');
            $table->string('addition_notes');

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('status_id')->constrained('statuses')->cascadeOnDelete();
=======
            $table->string('name');
            $table->string('trading_order_reference')->unique();
            $table->enum('condition' , ['new', 'like new', 'used', 'damaged']);
            $table->integer('storage_capacity');
            $table->text('accessories')->nullable();
            $table->date('purchase_date');
            $table->decimal('purchase_price' ,10,2)->nullable();
            $table->json('photos')->nullable();
            $table->text('additional_notes')->nullable();
            $table->integer('approximate_price')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('status_id')->default(1)->constrained('statuses')->cascadeOnDelete();
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
        Schema::dropIfExists('trade_centers');
    }
};
