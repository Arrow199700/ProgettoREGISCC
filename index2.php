<?php include_once("php/queryChart.php"); ?>
<?php
    include_once("php/dbconnection.php");
    $color1 = "#35682d";
    $color2 = "#2F5597";
    $color3 = "#FF0000";
    $color4 = "#D60093";
    $color5 = "#FFFF00";
    $colorC1 = "rgb(84, 130, 53, 0.7)";
    $colorC2 = "rgba(0, 51, 153, 0.7)";
    $colorC3 = "rgba(255, 0, 0, 0.6)";
    $colorC4 = "rgba(244, 0, 161, 0.7)";
    $colorC5 = "rgba(255, 255, 0, 0.6)";
    $ini = parse_ini_file('app.ini');

?>
<!DOCTYPE html>
<html lang="it" class="h-100">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Object Detection - MBC</title>
    <script src="js/jquery-3.6.0.js" ></script>
    <script src="js/lib_chart.js"></script>  
 
     <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css"  rel="stylesheet" />
    <link href="css/master.css"  rel="stylesheet" />

</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-1"><img src="img/imgregisc.png" /></div>
        <div class="col-10">
            <div class="title1 text-center">Advanced Recognition and Exploitation System</div>
            <div class="title2 text-center">Next Generation PED</div>
        </div>
        <div class="col-1"><img src="img/imgregisc2.png" /></div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="kpi_list">
                <div class="row kpi_item" style="color: <?php echo $color1 ?> !important;">
                    <div class="col-6 kpi_label">Individual</div>
                    <div id="nIndividual" class="col-6 kpi_value"></div>
                </div>
                <div class="row kpi_item" style="color: <?php echo $color2 ?> !important;">
                    <div class="col-6 kpi_label">Car</div>
                    <div id="nCar" class="col-6 kpi_value"></div>
                </div>
                <div class="row kpi_item" style="color: <?php echo $color3 ?> !important;">
                    <div class="col-6 kpi_label">Excavator</div>
                    <div id="nExcavator" class="col-6 kpi_value"></div>
                </div>
                <div class="row kpi_item" style="color: <?php echo $color4 ?> !important;">
                    <div class="col-6 kpi_label">Pick-Up</div>
                    <div id="nPickUp" class="col-6 kpi_value"></div>
                </div>
                <div class="row kpi_item" style="color: <?php echo $color5 ?> !important;">
                    <div class="col-6 kpi_label">Truck</div>
                    <div id="nTruck" class="col-6 kpi_value"></div>
                </div>
            </div>
            <div class="drone">

            </div>
        </div>
        <div class="col-6">
            <div class="vidoeTitle">Drone xyz - Video del 2020-09-11 15:35</div>
                <iframe width="100%" height="400" src="https://www.youtube.com/embed/lVdh571SwOQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="col-3">
            <p>Alert</p> 
            <div class="ctnAlert overflow-auto">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-9">
            <canvas id="myChart"></canvas>
        </div>
        <div class="col-3">
            <iframe width="100%" height="200" id="gmap_canvas" src="https://maps.google.com/maps?q=viale%20luigi%20schiavonetti&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>

        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    //console.log($ini);
    var ArrayCountPickup = Array();
    var ArrayCountIndividual = Array();
    var ArrayCountTruck = Array();
    var ArrayCountExcavator = Array();
    var ArrayCountCar = Array();
    var ArrayHourMinute = Array();
    var ArrayLabels = Array();
    var myChart = null;
    var secondi = 0;

    var nCar = 0;
    var nIndivid = 0;
    var nPickup = 0;
    var nTruck = 0;
    var nExcavator = 0;
    
    //query per andrea, contatore "ISTANTE" inizializzato a 0



    //per aggiornare i kpi

 
    function LoadArrayObjects(sLabel,ArrayTarget) {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: sLabel },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayTarget.push(element));
                console.log( sLabel + "- Values : " , ArrayTarget);
            }
        });
    }
    function LoadArrayPickup() {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: "Pick-up", istante: secondi },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayCountPickup.push(element));
            }
        });
    }    
    function LoadArrayExcavator() {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: "Excavator", istante: secondi },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayCountExcavator.push(element));
            }
        });
    }    
    function LoadArrayTruck() {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: "Truck", istante: secondi },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayCountTruck.push(element));
            }
        });
    }    
    function LoadArrayIndividual() {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: "Indiviual", istante: secondi },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayCountIndividual.push(element));
            }
        });
    }    
    function LoadArrayCar() {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: "Car", istante: secondi },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayCountCar.push(element));
            }
        });
    }    
    function AddKPI()
    {
        ArrayCountIndividual.push(nIndivid);
        ArrayCountCar.push(nCar)
        ArrayCountExcavator.push(nExcavator)
        ArrayCountPickup.push(nPickup)
        ArrayCountTruck.push(nTruck)
    }
    function AggiornaGrafico_New()
    {

        myChart.data.datasets[0].data = ArrayCountIndividual;
        myChart.data.datasets[1].data = ArrayCountCar;
        myChart.data.datasets[2].data = ArrayCountExcavator;
        myChart.data.datasets[3].data = ArrayCountPickup;
        myChart.data.datasets[4].data = ArrayCountTruck;
        myChart.data.labels = ArrayHourMinute;
        myChart.update();
        console.log("New chart updated.");
        
    }

     function AggiornaGrafico()
    {
        ArrayCountPickup = Array();
        ArrayCountIndividual = Array();
        ArrayCountTruck = Array();
        ArrayCountExcavator = Array();
        ArrayCountCar = Array();

        $.when(
            LoadArrayPickup(),
            LoadArrayIndividual(),
            LoadArrayCar(),
            LoadArrayExcavator(),
            LoadArrayTruck(),
            LoadArrayAsseX()
            ).done(function(response)
        {

            myChart.data.datasets[0].data = ArrayCountIndividual;
            myChart.data.datasets[1].data = ArrayCountCar;
            myChart.data.datasets[2].data = ArrayCountExcavator;
            myChart.data.datasets[3].data = ArrayCountPickup;
            myChart.data.datasets[4].data = ArrayCountTruck;
            myChart.data.labels = ArrayHourMinute;
            myChart.update();
            
             
        });
        console.log("Chart updated.");
    }

    function LoadArrayAsseX() {
        ArrayHourMinute = Array();
        var sql = "select secondi, count(*) as conteggio from tablenew where secondi <=" + secondi + "  group by secondi order by secondi;";
        var field = 'secondi';
        return $.ajax({
            method: "POST",
            url: "php/queryChart.php",
            data: { 
                "sql": sql,
                "field": field
             },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayHourMinute.push(element));
                //console.log(ArrayHourMinute, "HourMinute OK");
            }
        });
    }

    function CreaGrafico()
    {
        ArrayLabels = ["Individual" , "Car", "Excavator" , "Pick-Up" , "Truck"];
            // Printing the passed array elements
        //console.log(ArrayLabels, "Labels OK");

        var ctx = document.getElementById("myChart").getContext('2d');
        //console.log("Update chart");
        myChart = new Chart(ctx, {  
            type: 'line',
            plugins: {
                tooltip: {
                    mode: 'index'
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            data: {
                //Asse X
                labels: [ArrayHourMinute][0],
                datasets: [
                //Conteggio Pick-up
                    {
                    label: ArrayLabels[0],
                    data: [ArrayCountIndividual][0],
                    backgroundColor: '<?php echo $colorC1 ?>',
                    borderColor:'<?php echo $colorC1 ?>',
                    fill: true,
                    borderWidth: 2
                },
                //Conteggio Soldier
                {
                    label: ArrayLabels[1],
                    data: [ArrayCountCar][0],
                    borderColor: '<?php echo $colorC2 ?>',
                    fill: true,
                    backgroundColor:'<?php echo $colorC2 ?>',
                    borderWidth: 2
                },
                //Conteggio Truck
                {
                    label: ArrayLabels[2],
                    data: [ArrayCountExcavator][0],
                    borderColor: '<?php echo $colorC3 ?>',
                    fill: true,
                    backgroundColor:'<?php echo $colorC3 ?>',
                    borderWidth: 2
                },
                //Conteggio Tanker
                {
                    label: ArrayLabels[3],
                    data: [ArrayCountPickup][0],
                    borderColor: '<?php echo $colorC4 ?>',
                    fill: true,
                    backgroundColor:'<?php echo $colorC4 ?>',
                    borderWidth: 2
                },
                //Conteggio Truck
                {
                    label: ArrayLabels[4],
                    data: [ArrayCountTruck][0],
                    borderColor: '<?php echo $colorC5 ?>',
                    fill: true,
                    backgroundColor:'<?php echo $colorC5 ?>',
                    borderWidth: 2
                }
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: true
                    }
                }
            }
        });
    }
    function CountItems(sLabel,target) {
        return $.ajax({
            method: "POST",
            url: "php/queryFiltered.php",
            data: { 
                label: sLabel,
                istante: secondi
            },
            success: function(result){
                target = parseInt(result);
            }
        });
    }
    
    function CountCar()
    {
        return $.ajax({
            method: "POST",
            url: "php/queryFiltered.php",
            data: { 
                label: "Car",
                istante: secondi
            },
            success: function(result){
                nCar = parseInt(result);
            }
        });
    }
    function CountExcavator()
    {
        return $.ajax({
            method: "POST",
            url: "php/queryFiltered.php",
            data: { 
                label: "Excavator",
                istante: secondi
            },
            success: function(result){
                nExcavator = parseInt(result);
            }
        });
    }
    function CountIndivid()
    {
        return $.ajax({
            method: "POST",
            url: "php/queryFiltered.php",
            data: { 
                label: "Indiviual",
                istante: secondi
            },
            success: function(result){
                nIndivid = parseInt(result);
            }
        });
    }
    function CountTruck()
    {
        return $.ajax({
            method: "POST",
            url: "php/queryFiltered.php",
            data: { 
                label: "Truck",
                istante: secondi
            },
            success: function(result){
                nTruck = parseInt(result);
            }
        });
    }
    function CountPickup()
    {
        return $.ajax({
            method: "POST",
            url: "php/queryFiltered.php",
            data: { 
                label: "Pick-Up",
                istante: secondi
            },
            success: function(result){
                nPickup = result;
            }
        });
    }
    function PopulateKPI()
    {   
        secondi = secondi + 1;
        $.when(
            CountCar(),
            CountExcavator(),
            CountIndivid(),
            CountTruck(),
            CountPickup()
        ).done(function(response)
            {
                $("#nCar")[0].innerHTML = nCar;
                $("#nIndividual")[0].innerHTML = nIndivid;
                $("#nPickUp")[0].innerHTML = nPickup;
                $("#nTruck")[0].innerHTML = nTruck;
                $("#nExcavator")[0].innerHTML = nExcavator;
                ArrayHourMinute.push(secondi);
                AddKPI();
                AggiornaGrafico_New();
            }
        );
    }
    function popolaDB()
    {
        $.ajax({
            url: 'php/popolauto.php',
            type: 'GET',
            success: function(result){

            },

            error: function (xhr, ajaxOptions, thrownError) {

        }

        });
    }

$(document).ready(function(){
    secondi = -1;
    // $.when(
    //     LoadArrayPickup(),
    //     LoadArrayIndividual(),
    //     LoadArrayCar(),
    //     LoadArrayExcavator(),
    //     LoadArrayTruck(),
    //     LoadArrayAsseX()
    // ).done(function(response)
    // {
    //     CreaGrafico();
    // });

    CreaGrafico();
    PopulateKPI();

    // $.when(LoadArrayObjects("Pick-up",this.ArrayCountPickup) , 
    //         LoadArrayObjects("Indiviual",this.ArrayCountIndividual),
    //         LoadArrayObjects("Truck",this.ArrayCountTruck),
    //         LoadArrayObjects("Excavator",this.ArrayCountExcavator)
    //     ).done(function(response)
    //     {
    //         CreaGrafico();
    //     });
    setInterval(PopulateKPI, 1000);
    //setInterval(AggiornaGrafico, 1000);
    
    
});
    //funzione che in base al identificazione dell'excavator, PICK-UP e individui se sono più di 7

    var lastExcavator = parseInt($("#nExcavator")[0].innerHTML);
    var currExcavator = parseInt($("#nExcavator")[0].innerHTML);
    var lastpickup =    parseInt($("#nPickUp")[0].innerHTML);
    var currpickup =    parseInt($("#nPickUp")[0].innerHTML);
    var lastindivid =   parseInt($("#nIndividual")[0].innerHTML);
    var currindivid =   parseInt($("#nIndividual")[0].innerHTML);
setInterval(() => {
    
    var currindivid =   parseInt($("#nIndividual")[0].innerHTML);
    console.log("last", lastindivid);

    var currpickup =    parseInt($("#nPickUp")[0].innerHTML);
    console.log("Last", lastpickup);

    currExcavator = parseInt($("#nExcavator")[0].innerHTML);
    console.log("Last", lastExcavator);

    if (lastExcavator != currExcavator) {
        console.log("Curr", currExcavator);
        lastExcavator = currExcavator;
        $(".ctnAlert").append("<p>Excavator identificato al secondo " + ArrayHourMinute.slice(-1)  +  "</p>");
        scrollAlert();
    } else if ( currindivid >= 5) {
        lastindivid = currindivid;
        $(".ctnAlert").append("<p>Piu di 5 Individui identificati al secondo " + ArrayHourMinute.slice(-1)  +  "</p>");
        scrollAlert();
    } else {
        lastpickup = currpickup;
        $(".ctnAlert").append("<p>Pick-Up identificato al secondo " + ArrayHourMinute.slice(-1)  +  "</p>");
        scrollAlert();
    }


}, 1000);
function scrollAlert()
{
    $(".ctnAlert").scrollTop($(".ctnAlert")[0].scrollHeight);
}
  

</script>
