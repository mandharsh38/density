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
        Schema::create('measurement_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('measurement_id');
            $table->double('plate_area');
            $table->double('total_vol_loss_best_estimate');
            $table->double('total_vol_loss_max_volume');
            $table->double('total_vol_loss_min_volume');  
            $table->double('average_diameter');
            $table->double('average_depth');
            $table->double('average_depth_percent');
            $table->double('standard_deviation_diameter');
            $table->double('standard_deviation_depth');
            $table->double('avg_pit_loss_best_estimate');
            $table->double('avg_pit_loss_max_volume');
            $table->double('avg_pit_loss_min_volume');     
            $table->double('est_thick_loss_best_estimate');
            $table->double('est_thick_loss_max_volume');
            $table->double('est_thick_loss_min_volume');  
            $table->double('remain_plate_thick_best_estimate');
            $table->double('remain_plate_thick_max_volume');
            $table->double('remain_plate_thick_min_volume');  
            $table->double('remain_plate_percent_best_estimate');
            $table->double('remain_plate_percent_max_volume');
            $table->double('remain_plate_percent_min_volume');     
            $table->foreign('measurement_id')->references('id')->on('measurements')->onDelete('cascade');
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
        Schema::dropIfExists('measurement_details');
    }
};
