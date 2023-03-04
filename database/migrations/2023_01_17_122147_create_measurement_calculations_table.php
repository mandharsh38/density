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
        Schema::create('measurement_calculations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('measurement_id');
            $table->integer('measurement_number');
            $table->double('diameter');
            $table->double('depth');
            $table->double('depth_percent');
            $table->double('width_depth');
            $table->double('estimate_diameter_coef');
            $table->double('volume_max');
            $table->double('volume_min');           
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
        Schema::dropIfExists('measurement_calculations');
    }
};
