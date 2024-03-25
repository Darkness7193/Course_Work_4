<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('manufactor');
            $table->float('purchase_price');
            $table->float('selling_price');
            $table->string('comment');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
