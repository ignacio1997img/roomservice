<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesRoomsPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_rooms_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoryRoom_id')->nullable()->constrained('categories_rooms');
            $table->foreignId('partHotel_id')->nullable()->constrained('parts_hotels');


            $table->text('observation')->nullable();
            
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
        Schema::dropIfExists('categories_rooms_parts');
    }
}
