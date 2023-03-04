<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Density Calculator</title>
    <style>
        .sectionDiv {
            padding: 20px 20px;
            margin: 20px 20px;
            box-shadow: 0 0 40px 3px rgb(0 0 0 / 5%);
            border: 2px solid #f5f5f5;
            border-left: 2px solid red;
            background: white;
        }

        .sectionDiv .valueDiv .valClass {
            padding: 0px 0px 0px 15px;
        }

        .form-floating input {
            background-color: #52515129;
            border: none;
        }

        .main-section {
            background: #d5d5d54d;
        }

        .spacing-top {
            padding: 30px 0px 0px 0px;
        }

        .main-section .table td input {
            border: none;
            border-radius: 8px;
            border:2px solid #00000052;
            margin:10px 0px;
            padding:0px 0px 0px 5px;
        }

        .main-section .table  td input:focus{
            outline:none;
        }

        .main-section .table {
            margin:50px 0px 0px 0px;
        }

        .main-section input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

    </style>

</head>

<body>

    {{-- <a href="index.php">Home</a><br><br><br> --}}
    <div class="container-fluid main-section">
        <div class="row spacing-top">
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Density Calculator</h4><br>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" class="form-control initFormField" id="numMeasure" name="numMeasure"
                                placeholder="numMeasure" value=10 required>
                            <label for="numMeasure">Enter no. of Measurements</label>
                            <span style="color: red;" id="numMeasureSpan"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" class="form-control initFormField" id="cylCoeff" name="cylCoeff"
                                placeholder="cylCoeff" value=0.667 required readonly>
                            <label for="cylCoeff">Cyl Coefficent (c) </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12">
                            <label>Type of Average:</label>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input avgType" type="radio" name="avgType" id="medianAvg"
                                    value="median" checked>
                                <label class="form-check-label" for="medianAvg">Median</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input avgType" type="radio" name="avgType" id="meanAvg"
                                    value="mean">
                                <label class="form-check-label" for="meanAvg">Mean</label>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" class="form-control initFormField" id="plateThick" name="plateThick"
                                placeholder="plateThick" required>
                            <label for="plateThick">Enter Plate Thickness (mm) </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" class="form-control initFormField" id="plateLen" name="plateLen"
                                placeholder="plateLen" required>
                            <label for="plateLen">Enter Plate Length (mm) </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" class="form-control initFormField" id="plateWidth" name="plateWidth"
                                placeholder="plateWidth" required>
                            <label for="plateWidth">Enter Plate Width (mm) </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Diameter (w) mils</th>
                                        <th scope="col">Depth (d) mils</th>
                                        <th scope="col">Depth % of Plate Thickness</th>
                                        <th scope="col">w/d</th>
                                        <th id='cVal' scope="col">Estimate w/c</th>
                                        <th scope="col">Volume Max</th>
                                        <th scope="col">Volume Min</th>
                                    </tr>
                                </thead>
                                <tbody id='mainTableBody'>
                                </tbody>
                            </table>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="mainDiv">
                    <div style="margin-left:10%;">
                        <button class="btn btn-success">Save</button>
                    </div>
                    <div class="sectionDiv">
                        <div class="palte-div d-flex align-elements-center">
                            <div>
                                <h5>Plate Area:</h5>
                            </div>
                            <div id="plateArea" class="ps-2"></div>
                        </div>
                    </div>
                    <div class="sectionDiv">
                        <div>
                            <h5>Total Volume Loss (mm&sup2)</h5>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Best estimate:</div>
                            <div id="bestEstSum" class="valClass"></div>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Max Volume: </div>
                            <div id="maxVolSum" class="valClass"></div>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Min Volume: </div>
                            <div id="minVolSum" class="valClass"></div>
                        </div>
                    </div>
                    <div class="sectionDiv">
                        <div>
                            <h5 id="medianDDD">Median</h5>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Diameter: </div>
                            <div id="diaM" class="valClass"></div>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Depth: </div>
                            <div id="depthM" class="valClass"></div>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Depth % :  </div>
                            <div id="depthCentM" class="valClass"></div>
                        </div>
                    </div><div class="sectionDiv">
                        <div>
                            <h5 id="mPitLoss">Median Pit Loss Values</h5>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Best estimate:</div>
                            <div id="bestEstM" class="valClass"></div>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Max Volume: </div>
                            <div id="maxVolM" class="valClass"></div>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Min Volume: </div>
                            <div id="minVolM" class="valClass"></div>
                        </div>
                    </div>
                    <div class="sectionDiv">
                        <div>
                            <h5>Estimated Thickness Loss</h5>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Best estimate:</div>
                            <div id="bestEstThickLoss" class="valClass"></div>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Maximum: </div>
                            <div id="maxThickLoss" class="valClass"></div>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Minimum: </div>
                            <div id="minThickLoss" class="valClass"></div>
                        </div>
                    </div>
                    <div class="sectionDiv">
                        <h5>Remaining Plate Thickness (mm)</h5>
                        <div class="d-flex valueDiv">
                            <div>Best estimate:</div>
                            <div id="bestEstPlateThick" class="valClass"></div>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Maximum: </div>
                            <div id="maxPlateThick" class="valClass"></div>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Minimum: </div>
                            <div id="minPlateThick" class="valClass"></div>
                        </div>
                    </div>
                    <div class="sectionDiv">
                        <h5 id="remainPecentText">Remaining Plate as %</h5>
                        <div class="d-flex valueDiv">
                            <div>Best estimate:</div>
                            <div id="bestEstPlateThickPercent" class="valClass"></div>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Maximum: </div>
                            <div id="maxPlateThickPercent" class="valClass"></div>
                        </div>
                        <div class="d-flex valueDiv">
                            <div>Minimum: </div>
                            <div id="minPlateThickPercent" class="valClass"></div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                //initial 10 fields
                $(document).ready(function(){
                    for (var i = 0; i < 10; i++) {
                        let count = i + 1;
                        var tableRowHtml = "<tr>" +
                            "<th scope='row'>" + count + "</th>" +
                            "<td><input type='number' id='dia" + i + "' class='dia '></td>" +
                            "<td><input type='number' id='depth" + i + "' class='depth'></td>" +
                            "<td class='depthPercent' id='depthPercent" + i + "'></td>" +
                            "<td class='wByd' id='wByd" + i + "'></td>" +
                            "<td class='wByc' id='wByc" + i + "'></td>" +
                            "<td class='volMax' id='volMax" + i + "'></td>" +
                            "<td class='volMin' id='volMin" + i + "'></td>" +
                            "</tr>";
                        $('#mainTableBody').append(tableRowHtml);
                    }
                })

                // adding fields
                $(document).on('keyup', '#numMeasure', function() {

                    var numRows = $(this).val();

                    $('#mainTableBody').children().remove();
                    $('#numMeasureSpan').text("");

                    if (numRows <= 32){
                        for (var i = 0; i < numRows; i++) {
                            let count = i + 1;
                            var tableRowHtml = "<tr>" +
                                "<th scope='row'>" + count + "</th>" +
                                "<td><input type='number' id='dia" + i + "' class='dia '></td>" +
                                "<td><input type='number' id='depth" + i + "' class='depth'></td>" +
                                "<td class='depthPercent' id='depthPercent" + i + "'></td>" +
                                "<td class='wByd' id='wByd" + i + "'></td>" +
                                "<td class='wByc' id='wByc" + i + "'></td>" +
                                "<td class='volMax' id='volMax" + i + "'></td>" +
                                "<td class='volMin' id='volMin" + i + "'></td>" +
                                "</tr>";

                            $('#mainTableBody').append(tableRowHtml);
                        }
                    }else{
                        $('#numMeasureSpan').text("No. of Measurements cannot exceed 32");
                    }
                })

                var plateThickness;
                function storeThickVal(val) {
                    plateThickness = val;
                }

                $(document).on('blur', '#plateThick', function() {
                    storeThickVal($(this).val());
                    $('#remainPecentText').text("Remaining Plate as % of " + $(this).val() + " mm");
                })

                var typeAverage;
                function storeAverage(val) {
                    typeAverage = val;
                }

                $(document).on('change', '.avgType', function() {
                    storeAverage($(this).val());
                    if ($(this).val() == "mean") {
                        $('#mPitLoss').text("Mean Pit Loss Values");
                        $('#medianDDD').text("Mean");
                    }
                    if ($(this).val() == "median") {
                        $('#mPitLoss').text("Median Pit Loss Values");
                        $('#medianDDD').text("Median");
                    }
                })


                // validations

                // $(document).on('keyup', '#plateThick', function() {
                //     // if (typeof($(this).val))
                //     var val = $(this).val();
                //     console.log($.isNumeric(val));
                // })


                //arrays for values
                const depthPercentVal = [];
                const wBydVal = [];
                const wBycVal = [];
                const volMaxVal = [];
                const volMinVal = [];
                const diaVal = [];
                const depthVal = [];

                // calculations

                // depth %
                function depthPercent(depth, index) {
                    let plateThick = $('#plateThick').val();
                    let value = (depth / plateThick) * 100;
                    value = Math.round(value * 10) / 10;
                    depthPercentVal[index] = value;
                    return value;
                }

                // w/d
                function wByd(dia, depth, index) {
                    let value = dia / depth;
                    value = Math.round(value * 100) / 100;
                    wBydVal[index] = value;
                    return value;
                }

                // w/c
                function wByc(index) {
                    let cylCoeff = $('#cylCoeff').val();
                    let value = $('#volMax' + index).text();
                    value = value * cylCoeff;
                    value = Math.round(value * 100) / 100;
                    wBycVal[index] = value;
                    return value;
                }

                // Max Volume
                function volMax(dia, depth, index) {
                    let value = Math.PI * depth * ((dia / 2) ** 2);
                    value = Math.round(value * 10) / 10;
                    volMaxVal[index] = value;
                    return value;
                }

                // Min Volume
                function volMin(index) {
                    let value = $('#volMax' + index).text();
                    value = value / 3;
                    value = Math.round(value * 10) / 10;
                    volMinVal[index] = value;
                    return value;
                }

                // sum
                function sumArr(arr) {
                    let sum = 0;
                    arr.forEach((arrVal) => {
                        sum += arrVal;
                    })
                    sum = Math.round(sum * 100) / 100;
                    return sum;
                }

                //median
                function medianArr(arr) {
                    if (arr.length == 0) {
                        return;
                    }
                    arr.sort((a, b) => a - b);
                    const midpoint = Math.floor(arr.length / 2);
                    let median = arr.length % 2 === 1 ?
                        arr[midpoint] :
                        (arr[midpoint - 1] + arr[midpoint]) / 2;
                    median = Math.round(median * 100) / 100;
                    return median;
                }

                //mean
                function meanArr(arr) {
                    let total = 0;
                    let count = 0;
                    arr.forEach(function(item, index) {
                        total += item;
                        count++;
                    });
                    return total / count;
                }

                //calculations on the right side
                function calcLoss(sum) {
                    let value = sum / 9000;

                    value = Math.round(value * 100) / 100;
                    return value;
                }

                function remainThick(sum, thick) {
                    let value = sum / 9000;
                    value = thick - value;
                    value = Math.round(value * 100) / 100;
                    return value;
                }

                function calcPercentThick(remVal, thick) {
                    let value = remVal / thick;
                    value = Math.round(value * 100);
                    return value;
                }

                function updateCalculations(id) {

                    // let id = $(this).attr('id');

                    let match = id.match(/[0-9]+$/);
                    let index = parseInt(match[0]);

                    let dia = $('#dia' + index).val();
                    let depth = $('#depth' + index).val();

                    diaVal [index] = parseInt(dia);
                    depthVal[index] = parseInt(depth); 

                    // console.log("depth ="+depth);
                    // console.log("dia ="+dia);

                    $('#depthPercent' + index).text(depthPercent(depth, index) + "%");
                    $('#wByd' + index).text(wByd(dia, depth, index));
                    $('#volMax' + index).text(volMax(dia, depth, index));
                    $('#wByc' + index).text(wByc(index));
                    $('#volMin' + index).text(volMin(index));

                    // calculations on the right side
                    var estSum = sumArr(wBycVal);
                    var maxSum = sumArr(volMaxVal);
                    var minSum = sumArr(volMinVal);

                    $('#bestEstSum').text(estSum);
                    $('#maxVolSum').text(maxSum);
                    $('#minVolSum').text(minSum);

                    if (typeAverage == "mean") {
                        $('#bestEstM').text(meanArr(wBycVal));
                        $('#maxVolM').text(meanArr(volMaxVal));
                        $('#minVolM').text(meanArr(volMinVal));
                        $('#diaM').text(meanArr(diaVal));
                        $('#depthM').text(meanArr(depthVal));
                        $('#depthCentM').text(meanArr(depthPercentVal));
                    } else {
                        $('#bestEstM').text(medianArr(wBycVal));
                        $('#maxVolM').text(medianArr(volMaxVal));
                        $('#minVolM').text(medianArr(volMinVal));
                        $('#diaM').text(medianArr(diaVal));
                        $('#depthM').text(medianArr(depthVal));
                        $('#depthCentM').text(medianArr(depthPercentVal));
                    }

                    $('#bestEstThickLoss').text(calcLoss(estSum));
                    $('#maxThickLoss').text(calcLoss(maxSum));
                    $('#minThickLoss').text(calcLoss(minSum));

                    var remainThickEst = remainThick(estSum, plateThickness);
                    var remainThickMax = remainThick(maxSum, plateThickness);
                    var remainThickMin = remainThick(minSum, plateThickness);

                    $('#bestEstPlateThick').text(remainThickEst);
                    $('#maxPlateThick').text(remainThickMax);
                    $('#minPlateThick').text(remainThickMin);

                    $('#bestEstPlateThickPercent').text(calcPercentThick(remainThickEst, plateThickness) + '%');
                    $('#maxPlateThickPercent').text(calcPercentThick(remainThickMax, plateThickness) + '%');
                    $('#minPlateThickPercent').text(calcPercentThick(remainThickMin, plateThickness) + '%');

                }

                // Updating calcultaions
                $(document).on('change', 'input', function() {
                    $('.calc').each(function(){
                        console.log($(this).html());
                        updateCalculations($(this).attr('id'))
                    })
                })

                // $(document).on('change', 'input.', function() {
                    
                //     updateCalculations($(this).attr('id'))
                // })
                

                // Add value of c to column

                $(document).on('keyup', '#cylCoeff', function() {
                    $('#cVal').text('Estimate w/c = ' + $('#cylCoeff').val() + ')');
                })

                //  calculate plate area

                function plateArea() {
                    var len = $('#plateLen').val();
                    var wid = $('#plateWidth').val();
                    return len * wid;
                }

                $(document).on('keyup', '#plateWidth', function() {
                    $('#plateArea').html("<h5>" + plateArea() + "</h5>");
                })
                $(document).on('keyup', '#plateLen', function() {
                    $('#plateArea').html("<h5>" + plateArea() + "</h5>");
                })
            </script>
</body>

</html>
