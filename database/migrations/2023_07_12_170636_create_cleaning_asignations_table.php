<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCleaningAsignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cleaning_asignations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('room_id')->nullable()->constrained('rooms');

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
        Schema::dropIfExists('cleaning_asignations');
    }
}
