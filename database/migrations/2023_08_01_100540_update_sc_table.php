<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateScTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_rooms_clients', function (Blueprint $table) {
            // Para poder ver su procedencia
            $table->smallInteger('foreign')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->foreignId('province_id')->nullable()->constrained('provinces');
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->text('origin')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
