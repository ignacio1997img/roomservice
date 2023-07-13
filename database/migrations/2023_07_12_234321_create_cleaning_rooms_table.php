<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCleaningRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cleaning_rooms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cleaningAsignation_id')->nullable()->constrained('cleaning_asignations');
            $table->foreignId('room_id')->nullable()->constrained('rooms');

            $table->date('date')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('finish')->nullable();
            $table->text('observation')->nullable();

            $table->foreignId('starUser_id')->nullable()->constrained('users');
            $table->foreignId('finishUser_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('cleaning_rooms');
    }
}
