<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('url', 255)->nullable();
            $table->string('brand', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->string('year', 255)->nullable();
            $table->string('option', 255)->nullable();
            $table->string('engine_cylinders', 255)->nullable();
            $table->string('engine_displacement', 255)->nullable();
            $table->string('engine_power', 255)->nullable();
            $table->string('engine_torque', 255)->nullable();
            $table->string('engine_fuel_system', 255)->nullable();
            $table->string('engine_fuel', 255)->nullable();
            $table->string('engine_c2o', 255)->nullable();
            $table->string('performance_top_speed', 255)->nullable();
            $table->string('performance_acceleration', 255)->nullable();
            $table->string('fuel_economy_city', 255)->nullable();
            $table->string('fuel_economy_highway', 255)->nullable();
            $table->string('fuel_economy_combined', 255)->nullable();
            $table->string('transmission_drive_type', 255)->nullable();
            $table->string('transmission_gearbox', 255)->nullable();
            $table->string('brakes_front', 255)->nullable();
            $table->string('brakes_rear', 255)->nullable();
            $table->string('tires_size', 255)->nullable();
            $table->string('dimensions_length', 255)->nullable();
            $table->string('dimensions_width', 255)->nullable();
            $table->string('dimensions_height', 255)->nullable();
            $table->string('dimensions_front_rear_track', 255)->nullable();
            $table->string('dimensions_wheelbase', 255)->nullable();
            $table->string('dimensions_ground_clearance', 255)->nullable();
            $table->string('dimensions_cargo_volume', 255)->nullable();
            $table->string('dimensions_cd', 255)->nullable();
            $table->string('weight_unladen', 255)->nullable();
            $table->string('weight_limit', 255)->nullable();
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
        Schema::dropIfExists('cars');
    }
}
