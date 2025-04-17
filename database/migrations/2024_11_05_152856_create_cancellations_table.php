<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancellationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancellations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_request_id')->constrained('ride_requests')->onDelete('cascade');
            //$table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con la tabla 'users'
            $table->foreignId('cancellation_reason_id')->constrained('cancellation_reasons')->onDelete('restrict');
            $table->text('additional_description')->nullable(); // Descripción adicional opcional
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
        Schema::dropIfExists('cancellations');
    }
}
