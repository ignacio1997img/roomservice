<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('income_id')->nullable()->constrained('incomes');
            $table->foreignId('article_id')->nullable()->constrained('articles');
            $table->double('cantSolicitada',9.2)->nullable();
            $table->double('cantRestante', 9.2)->nullable();
            $table->double('price', 9.2)->nullable();
            $table->double('amount', 9.2)->nullable();
            $table->datetime('expiration')->nullable();
            $table->smallInteger('expirationStatus')->default(1);

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
        Schema::dropIfExists('incomes_details');
    }
}
