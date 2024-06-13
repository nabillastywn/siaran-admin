<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sarana_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sarpras_id');
            $table->unsignedBigInteger('user_id');
            $table->string('location');
            $table->date('date');
            $table->text('report');
            $table->string('attachment')->nullable();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('sarpras_id')->references('id')->on('sarpras')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sarana_reports');
    }
};