<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_rooms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_id')->nullable()->constrained('rooms');
            $table->foreignId('people_id')->nullable()->constrained('people');
            $table->integer('number')->nullable();
            $table->string('category')->nullable();
            $table->string('facility')->nullable();

            $table->decimal('amount', 9,2)->nullable();

            $table->text('observation')->nullable();

            $table->smallInteger('status')->default(1);
            $table->datetime('start')->nullable();
            $table->datetime('finish')->nullable();
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
        Schema::dropIfExists('service_rooms');
    }
}