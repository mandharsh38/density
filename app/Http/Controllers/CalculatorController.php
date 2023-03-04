<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Measurements;
use App\Models\MeasurementCalculations;
use App\Models\MeasurementDetails;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Redirect;

class CalculatorController extends Controller
{
    public function index(Request $request)
    {
        return view('calculator.index');
    }
    public function save(Request $request)
    {

        // dd($request);

        // validations

        $request->validate([
            'numMeasure' => 'required | numeric',
            'cylCoeff' => 'required | numeric',
            'avgType' => 'required',
            'plateThick' => 'required | numeric',
            'plateLen' => 'required | numeric',
            'plateWidth' => 'required | numeric',
            'description' => 'required'
        ]);

        $measurement = new Measurements();

        $measurement->no_of_measurements = $request->numMeasure;
        $measurement->coefficent = $request->cylCoeff;
        $measurement->average_type = $request->avgType;
        $measurement->plate_thickness = $request->plateThick;
        $measurement->plate_length = $request->plateLen;
        $measurement->plate_width = $request->plateWidth;
        $measurement->description = $request->description;

        $measurement->save();

        $id = $measurement->id;
        // dd($id);

        // functions for backend validation
        function plateArea($len, $width)
        {
            $value = $len * $width;
            return $value;
        }

        function calculateDepthPercent($depth, $plateThick)
        {
            $value = ($depth / $plateThick) * 100;
            $value = round($value * 10) / 10;
            return $value;
        }

        function calculateWbyd($dia, $depth)
        {
            $value = $dia / $depth;
            $value = round($value * 100) / 100;
            return $value;
        }

        function calculateWbyc($volMax, $cylCoeff)
        {
            $value = $volMax * $cylCoeff;
            $value = round($value * 100) / 100;
            return $value;
        }

        function calculateVolMax($dia, $depth)
        {
            $value = M_PI * $depth * (($dia / 2) ** 2);
            $value = round($value * 10) / 10;
            return $value;
        }

        function calculateVolMin($volMax)
        {
            $value = $volMax / 3;
            $value = round($value * 10) / 10;
            return $value;
        }

        function sumArr($arr)
        {
            $sum = 0;
            foreach ($arr as $val) {
                $sum += $val;
            }
            $sum = round($sum * 100) / 100;
            return $sum;
        }

        function medianArr($arr)
        {
            rsort($arr);
            $size = count($arr);
            $middle = count($arr) / 2;
            if ($size  % 2 != 0) {
                $median = $arr[$middle];
            } else {
                $median1 = $arr[$middle];
                $median2 = $arr[$middle - 1];
                $median = ($median1 + $median2) / 2;
            }
            $median = round($median * 100) / 100;
            return $median;
        }

        function meanArr($arr)
        {
            $sum = sumArr($arr);
            $count = count($arr) + 1;
            $value = $sum / $count;
            $value = round($value * 100) / 100;
            return $value;
        }

        function calcLoss($sum)
        {
            $value = $sum / 9000;
            $value = round($value * 100) / 100;
            return $value;
        }

        function remainThick($sum, $plateThick)
        {
            $value = $sum / 9000;
            $value = $plateThick - $value;
            $value = round($value * 100) / 100;
            return $value;
        }

        function calcPercentThick($remVal, $plateThick)
        {
            $value = $remVal / $plateThick;
            $value = round($value * 100);
            return $value;
        }

        function stdDeviationSample($arr)
        {
            $len = count($arr);
            $mean = sumArr($arr) / $len;
            $variance = 0.0;
            foreach ($arr as $i) {
                $variance += pow(($i - $mean), 2);
            }
            $value = (float)sqrt($variance / ($len - 1));
            $value = round($value * 100) / 100;
            return $value;
        }

        $numMeasurements = $request->numMeasure;
        $diaArr = $request->dia;
        $depthArr = $request->depth;
        $plateThick = $request->plateThick;
        $cylCoeff = $request->cylCoeff;
        $plateLength = $request->plateLen;
        $plateWidth = $request->plateWidth;
        $averageType = $request->avgType;


        // calculation of table values
        $plateArea = plateArea($plateLength, $plateWidth);

        // init arrays
        $depthPercentArr = [];
        $wBydArr = [];
        $wBycArr = [];
        $volMaxArr = [];
        $volMinArr = [];

        for ($i = 0; $i < $numMeasurements; $i++) {
            $dia = floatval($diaArr[$i]);
            $depth = floatval($depthArr[$i]);

            // make calculations
            $depthPercent = calculateDepthPercent($depth, $plateThick);
            $wByd = calculateWbyd($dia, $depth);
            $volMax = calculateVolMax($dia, $depth);
            $volMin = calculateVolMin($volMax);
            $wByc = calculateWbyc($volMax, $cylCoeff);

            // push into arrays
            array_push($depthPercentArr, $depthPercent);
            array_push($wBydArr, $wByd);
            array_push($wBycArr, $wByc);
            array_push($volMaxArr, $volMax);
            array_push($volMinArr, $volMin);
        }

        // details table values

        $bestEstSum = sumArr($wBycArr);;
        $maxVolSum = sumArr($volMaxArr);
        $minVolSum = sumArr($volMinArr);

        if ($averageType == "median") {
            $bestEstM = medianArr($wBycArr);
            $maxVolM = medianArr($volMaxArr);
            $minVolM = medianArr($volMinArr);
            $diaM = medianArr($diaArr);
            $depthM = medianArr($depthArr);
            $depthCentM = medianArr($depthPercentArr);
        }
        if ($averageType == "mean") {
            $bestEstM = meanArr($wBycArr);
            $maxVolM = meanArr($volMaxArr);
            $minVolM = meanArr($volMinArr);
            $diaM = meanArr($diaArr);
            $depthM = meanArr($depthArr);
            $depthCentM = meanArr($depthPercentArr);
        }

        $devDia = stdDeviationSample($diaArr);
        $devDepth = stdDeviationSample($depthArr);
        $bestEstThickLoss = calcLoss($bestEstSum);
        $maxThickLoss = calcLoss($maxVolSum);
        $minThickLoss = calcLoss($minVolSum);

        $remainThickEst = remainThick($bestEstSum, $plateThick);
        $remainThickMax = remainThick($maxVolSum, $plateThick);
        $remainThickMin = remainThick($minVolSum, $plateThick);

        $bestEstPlateThickPercent = calcPercentThick($remainThickEst, $plateThick);
        $maxPlateThickPercent = calcPercentThick($remainThickMax, $plateThick);
        $minPlateThickPercent = calcPercentThick($remainThickMin, $plateThick);

        for ($i = 0; $i < $numMeasurements; $i++) {

            // adding to calculations table
            $count = $i + 1;

            $calculation = new MeasurementCalculations();
            $calculation->measurement_id = $id;
            $calculation->measurement_number = $count;
            $calculation->diameter = $diaArr[$i];
            $calculation->depth = $depthArr[$i];
            $calculation->depth_percent = $depthPercentArr[$i];
            $calculation->width_depth = $wBydArr[$i];
            $calculation->estimate_diameter_coef = $wBycArr[$i];
            $calculation->volume_max = $volMaxArr[$i];
            $calculation->volume_min = $volMinArr[$i];

            $calculation->save();
        }

        // adding to details table

        $detail = new MeasurementDetails();

        $detail->measurement_id = $id;
        $detail->plate_area = $plateArea;
        $detail->total_vol_loss_best_estimate = $bestEstSum;
        $detail->total_vol_loss_max_volume = $maxVolSum;
        $detail->total_vol_loss_min_volume = $minVolSum;
        $detail->average_diameter = $diaM;
        $detail->average_depth = $depthM;
        $detail->average_depth_percent = $depthCentM;
        $detail->standard_deviation_diameter = $devDia;
        $detail->standard_deviation_depth = $devDepth;
        $detail->avg_pit_loss_best_estimate = $bestEstM;
        $detail->avg_pit_loss_max_volume = $maxVolM;
        $detail->avg_pit_loss_min_volume = $minVolM;
        $detail->est_thick_loss_best_estimate = $bestEstThickLoss;
        $detail->est_thick_loss_max_volume = $maxThickLoss;
        $detail->est_thick_loss_min_volume = $minThickLoss;
        $detail->remain_plate_thick_best_estimate = $remainThickEst;
        $detail->remain_plate_thick_max_volume = $remainThickMax;
        $detail->remain_plate_thick_min_volume = $remainThickMin;
        $detail->remain_plate_percent_best_estimate = $bestEstPlateThickPercent;
        $detail->remain_plate_percent_max_volume = $maxPlateThickPercent;
        $detail->remain_plate_percent_min_volume = $minPlateThickPercent;

        $detail->save();

        return redirect()->route('calculator.index')->with('message', 'success');
    }
}
