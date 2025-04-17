<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('amount');
            $table->integer('rides_qty');
            $table->string('start_date_type', 20)->default('fixed');
            $table->dateTime('starts_at')->nullable();
            $table->string('end_date_type', 20)->default('fixed');
            $table->dateTime('ends_at')->nullable();
            $table->integer('days_to_expiration')->nullable();
            $table->string('status', 20)->default('inactive');
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
        Schema::dropIfExists('bonuses');
    }
}
