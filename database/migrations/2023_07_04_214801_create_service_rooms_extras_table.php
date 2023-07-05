<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRoomsExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_rooms_extras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serviceRoom_id')->nullable()->constrained('service_rooms');

            $table->string('detail')->nullable();
            $table->decimal('amount', 9,2)->nullable();



            $table->timestamps();
            $table->foreignId('registerUser_id')->nullable()->constrained('users');
            $table->string('registerRol')->nullable();

            $table->softDeletes();

            $table->foreignId('deleteUser_id')->nullable()->constrained('users');
            $table->string('deleteRol')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_rooms_extras');
    }
}
