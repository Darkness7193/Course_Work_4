<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_moves', function(Blueprint $table) {

            $table->dropForeign('product_moves_start_storage_id_foreign');
            $table->dropColumn('start_storage_id');
            $table->foreignId('storage_id')->references('id')->on('storages')->constrained();

            $table->dropForeign('product_moves_end_storage_id_foreign');
            $table->dropColumn('end_storage_id');
            $table->foreignId('new_storage_id')->nullable()->references('id')->on('storages')->constrained();
        });
    }
    public function down(): void
    {
        //
    }
};
