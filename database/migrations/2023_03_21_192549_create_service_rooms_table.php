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
            $table->foreignId('people_id')->nullable()->constrained('people'); //Para la persona que se hospeda
            $table->foreignId('recommended_id')->nullable()->constrained('people');//Para la persona que recomienda

            $table->integer('number')->nullable();
            $table->string('category')->nullable();
            $table->string('facility')->nullable();

            $table->decimal('amount', 9,2)->nullable(); //contiene el total de los dias hospedado por el precio de la habitacion
            $table->decimal('debt', 9,2)->nullable(); //Contiene los pagos totales de articulo y comida mas hospedaje

            $table->smallInteger('day')->nullable();
            $table->decimal('amountTotal', 9,2)->nullable();

            $table->decimal('typePrice', 9,2)->nullable();
            $table->string('typeAmount')->nullable();

            $table->smallInteger('qr')->nullable();
            

            $table->smallInteger('reserve')->nullable();


            $table->text('observation')->nullable();

            $table->string('status')->nullable();
            $table->datetime('start')->nullable();
            $table->datetime('finish')->nullable();


            // Para poder ver su procedencia
            $table->smallInteger('foreign')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->foreignId('province_id')->nullable()->constrained('provinces');
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->text('origin')->nullable();

            $table->string('typeHospedaje')->nullable();//Porq se esta alojando



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
