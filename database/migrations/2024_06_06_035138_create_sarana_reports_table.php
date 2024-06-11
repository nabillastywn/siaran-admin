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
            $table->unsignedInteger('sarpras_id');
            $table->unsignedInteger('user_mhs_id');
            $table->string('location');
            $table->date('date');
            $table->string('report');
            $table->string('attachment');
            $table->string('slug');
            $table->unsignedInteger('statuses_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sarana_reports');
    }
};