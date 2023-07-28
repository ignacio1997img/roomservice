<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('people_id')->nullable()->constrained('people');
            $table->foreignId('job_id')->nullable()->constrained('jobs');
            $table->string('code')->nullable();

            $table->date('start')->nullable();
            $table->date('finish')->nullable();

            $table->text('details_work')->nullable();

            $table->text('table_report')->nullable();
            $table->text('details_report')->nullable();

            $table->text('documents_contract')->nullable();


            $table->string('status')->nullable()->default('elaborado');

            $table->foreignId('registerUser_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('contracts');
    }
}
