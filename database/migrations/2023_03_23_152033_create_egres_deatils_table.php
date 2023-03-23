<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgresDeatilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egres_deatils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('egre_id')->nullable()->constrained('egres');
            $table->foreignId('article_id')->nullable()->constrained('articles');
            $table->foreignId('incomeDetail_id')->nullable()->constrained('incomes_details');

            $table->decimal('cantSolicitada', 9,2)->nullable();
            $table->decimal('price', 9,2)->nullable();
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
        Schema::dropIfExists('egres_deatils');
    }
}
