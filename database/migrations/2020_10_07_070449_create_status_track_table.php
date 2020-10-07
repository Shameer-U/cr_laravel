<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTrackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_track', function (Blueprint $table) {
            $table->id();
            $table->integer('complaint_no');
            $table->string('pending')->default('');
            $table->string('waiting_for_approval')->default('');
            $table->string('approved')->default('');
            $table->string('rejected')->default('');
            $table->string('completed')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_track');
    }
}
