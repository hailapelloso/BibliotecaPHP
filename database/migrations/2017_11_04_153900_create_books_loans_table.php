<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_loans', function (Blueprint $table) {
            $table->integer('book_id')->unsigned();
            $table->integer('loan_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('books_loans', function(Blueprint $table){
            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('loan_id')->references('id')->on('loans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books_loans');
    }
}
