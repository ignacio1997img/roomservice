<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCleaningRoomsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cleaning_rooms_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cleaningRoom_id')->nullable()->constrained('cleaning_rooms');

            $table->foreignId('cleaningProductDetail_id')->nullable()->constrained('cleaning_products_details');
            $table->foreignId('article_id')->nullable()->constrained('articles');
            

            $table->decimal('price', 9,2)->nullable();
            $table->decimal('cant', 9,2)->nullable();
            $table->decimal('amount', 9,2)->nullable();

            $table->foreignId('userRegister_id')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cleaning_rooms_products');
    }
}
