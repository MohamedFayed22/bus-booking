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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained('trips')->noActionOnDelete();
            $table->foreignId('user_id')->constrained('users')->noActionOnDelete();
            $table->foreignId('station_id')->constrained('stations')->noActionOnDelete();
            $table->foreignId('destination_id')->constrained('destinations')->noActionOnDelete();
            $table->string('status')->default('processing');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->dateTime('booking_time');
            $table->integer('seats_count');
            $table->double('price');
            $table->double('discount')->default(0);
            $table->double('total_price');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
