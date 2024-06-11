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
        Schema::create('bullying_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_mhs_id');
            $table->string('location');
            $table->date('date');
            $table->string('description');
            $table->string('attachment');
            $table->string('slug');
            $table->unsignedBigInteger('statuses_id');
            $table->timestamps();

            $table->foreign('user_mhs_id')->references('id')->on('user_mhs')->onDelete('cascade');
            $table->foreign('statuses_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bullying_reports');
    }
};