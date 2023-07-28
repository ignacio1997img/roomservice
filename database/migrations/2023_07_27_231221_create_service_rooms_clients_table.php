<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRoomsClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_rooms_clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serviceRoom_id')->nullable()->constrained('service_rooms');
            $table->foreignId('people_id')->nullable()->constrained('people'); //Para la persona que se hospeda
            $table->smallInteger('payment')->nullable();


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
        Schema::dropIfExists('service_rooms_clients');
    }
}
