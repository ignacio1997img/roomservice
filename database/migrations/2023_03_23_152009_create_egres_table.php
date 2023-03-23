<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained('rooms');
            $table->foreignId('people_id')->nullable()->constrained('people');

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
        Schema::dropIfExists('egres');
    }
}
