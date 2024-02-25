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
        Schema::table('product_moves', function(Blueprint $table) {

            $table->dropForeign('purchases_storage_id_foreign');
            $table->dropColumn('storage_id');
            $table->foreignId('start_storage_id')->references('id')->on('storages')->constrained();

            $table->foreignId('end_storage_id')->references('id')->on('storages')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
