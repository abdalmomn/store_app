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
            $table->string('name');
<<<<<<< HEAD
            $table->enum('type',['discount','fixed_price']);
            $table->decimal('value' , 8 , 2);
=======
            $table->decimal('discount_amount' , 8 , 2);
            $table->integer('discount_percentage');
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            $table->date('start_date');
            $table->date('end_date');
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
