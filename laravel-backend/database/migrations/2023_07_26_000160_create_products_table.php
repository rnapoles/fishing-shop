<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('serial_number', 255)->unique();
            $table->float('purchase_price');
            $table->float('sale_price');
            $table->integer('units_in_stock');
            $table->boolean('available_in_stock')->nullable();

            // N .. 1
            $table->foreignId('category_id')
                ->constrained('categories')
                ->onDelete('cascade');

            //Optimistic Locking
            $table->integer('lock_version')
                ->unsigned()
                ->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
