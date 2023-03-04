<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurements extends Model
{
    use HasFactory;

    protected $table = 'measurements';
    protected $fillable = ['no_of_measurements', 'coefficent', 'plate_thickness', 'plate_length', 'plate_width', 'average_type', 'description'];

}
