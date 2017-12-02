<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('devolution_date')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        Schema::table('loans', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
