<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementDetails extends Model
{
    use HasFactory;

    protected $table = 'measurement_details';
    protected $fillable = ['measurement_id', 'plate_area', 'average_diameter', 'average_depth', 'average_depth_percent', 'standard_deviation_diameter', 'standard_deviation_depth', 'total_vol_loss_best_estimate', 'total_vol_loss_max_volume', 'total_vol_loss_min_volume', 'avg_pit_loss_best_estimate', 'avg_pit_loss_max_volume', 'avg_pit_loss_min_volume', 'est_thick_loss_best_estimate', 'est_thick_loss_max_volume', 'est_thick_loss_min_volume', 'remain_plate_thick_best_estimate', 'remain_plate_thick_max_volume', 'remain_plate_thick_min_volume', 'remain_plate_percent_best_estimate', 'remain_plate_percent_max_volume', 'remain_plate_percent_min_volume'];

}
 