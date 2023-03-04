<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementCalculations extends Model
{
    use HasFactory;

    protected $table = 'measurement_calculations';
    protected $fillable = ['measurement_id', 'measurement_number', 'diameter', 'depth', 'depth_percent', 'width_depth', 'estimate_diameter_coef', 'volume_max', 'volume_min'];

}
