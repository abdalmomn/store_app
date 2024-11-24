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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string('code');
            $table->decimal('discount_amount',8,2);
            $table->integer('discount_percentage');
            $table->integer('usage_limit');
            $table->integer('usage_count');
            $table->date('expires_in');
=======
            $table->string('code')->unique();
            $table->integer('discount_percentage')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_count')->nullable()->default(0);
            $table->date('expires_in')->nullable();
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
