<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_book');
            $table->unsignedBigInteger('id_type');
            $table->timestamps();
            $table->foreign('id_book')->references('id')->on('books');
            $table->foreign('id_type')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_types');
    }
};
