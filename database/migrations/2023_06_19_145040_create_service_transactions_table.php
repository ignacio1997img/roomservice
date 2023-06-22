<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serviceRoom_id')->nullable()->constrained('service_rooms');

            $table->decimal('amount', 9,2)->nullable();
            $table->smallInteger('qr')->nullable();
            $table->string('type')->nullable();



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
        Schema::dropIfExists('service_transactions');
    }
}
