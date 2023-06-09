<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgresMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egres_menus', function (Blueprint $table) {
            $table->id();            

            $table->foreignId('egre_id')->nullable()->constrained('egres');


            $table->foreignId('food_id')->nullable()->constrained('food');
            

            $table->decimal('price', 9,2)->nullable();
            $table->decimal('cant', 9,2)->nullable();
            $table->decimal('amount', 9,2)->nullable();


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
        Schema::dropIfExists('egres_menus');
    }
}
