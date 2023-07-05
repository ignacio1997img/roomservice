<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCleaningProductsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cleaning_products_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cleaningProduct_id')->nullable()->constrained('cleaning_products');
            $table->foreignId('article_id')->nullable()->constrained('articles');
            $table->double('cantSolicitada',9.2)->nullable();
            $table->double('cantRestante', 9.2)->nullable();
            $table->double('price', 9.2)->nullable();
            $table->double('amount', 9.2)->nullable();
            // $table->date('expiration')->nullable();
            // $table->smallInteger('expirationStatus')->default(1);

            $table->timestamps();
            $table->foreignId('registerUser_id')->nullable()->constrained('users');
            $table->softDeletes();
            $table->foreignId('deletedUser_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cleaning_products_details');
    }
}
