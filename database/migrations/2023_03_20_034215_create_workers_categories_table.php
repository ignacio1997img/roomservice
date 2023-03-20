<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->nullable()->constrained('workers');
            $table->foreignId('categoryWorker_id')->nullable()->constrained('categories_workers');
            $table->text('observation')->nullable();
            // $table->smallInteger('status')->default(1);
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
        Schema::dropIfExists('workers_categories');
    }
}
