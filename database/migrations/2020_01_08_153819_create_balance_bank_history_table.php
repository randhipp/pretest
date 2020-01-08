<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceBankHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_bank_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bank_balance_id');
            $table->integer('balance_before');
            $table->integer('balance_after');
            $table->integer('activity');
            $table->enum('type',['debit','credit']);
            $table->string('ip');
            $table->string('location');
            $table->string('user_agent');
            $table->string('author');
            $table->timestamps();
        });

        // add foreign key
        Schema::table('balance_bank_history', function (Blueprint $table) {
            $table->foreign('bank_balance_id')->references('id')->on('balance_bank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_bank_history');
    }
}
