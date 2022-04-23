<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'app/php/config.php';
include 'app/class/Klant.php';

if (!isset($_SESSION['ID'])) {
    header("Location: inlog.php");
    exit();
}

if ($_SESSION['rechten'] != 0) {
    header("Location: index.php");
    exit();
}

$heeftRecords = true;
$klantID = $_SESSION["ID"];
$jaren = array();


//kijk of de gebruiker records heeft in de verbruik tabel
$query = "SELECT * FROM verbruik WHERE klantID = {$klantID}";
$result = $conn->query($query);
if($result->num_rows <= 0) {
    $heeftRecords = false;
}else {
    $row = $result->fetch_array();
    $standaardJaar = $row[3];
    $standaardType = $row[2];



    if (isset($_GET['jaar']) && isset($_GET['type'])) {
        $type = $_GET['type'];
        $jaar = $_GET['jaar'];
    
        //controlle + alle jaren ophalen met meegegeven type
        $controlle = "SELECT * FROM verbruik WHERE klantID = {$klantID} AND `type` ='".$type."'";
        $result1 = $conn->query($controlle);
        if ($result1->num_rows > 0) {
            while($get = $result1->fetch_array()) {
                array_push($jaren, $get[3]);
                $minJaar = min($jaren);
            }
        }else {
            //als de GET value fout is of niet klopt, laat dan de gegevens zien met de standaard values
            header("Location: overzicht.php?jaar={$standaardJaar}&type={$standaardType}");
            exit();
        }
    
        //Selecteer data van meegegeven jaar + type
        $querry = "SELECT * FROM `verbruik` WHERE klantID = {$klantID} AND `type` = '{$type}' AND `jaar` =".$jaar;
        $result = $conn->query($querry);
        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            $data = $row[4].", ".$row[5].", ".$row[6].", ".$row[7].", ".$row[8].", ".$row[9].", ".$row[10].", ".$row[11].", ".$row[12].", ".$row[13].", ".$row[14].", ".$row[15];
            if ($type == "stroom") {
                $totaalVerbruik = $row[16]. " kWh";
            }else {
                $totaalVerbruik = $row[16]. " m3";
            }
    
    
            //Vergelijk query
            if(isset($_GET['vergelijk'])) {
                if($_GET['vergelijk'] == "true"){
                    $querry = "SELECT AVG(januari), AVG(februari), AVG(maart), AVG(april), AVG(mei), AVG(juni), AVG(juli), AVG(augustus), AVG(september), AVG(oktober), AVG(november), AVG(december), AVG(totaalVerbruik) FROM verbruik WHERE `jaar` ={$jaar} AND `type` = '{$type}'";
                    $result = $conn->query($querry);
                    $row = $result->fetch_array();
                    $data2 = $row[0].", ".$row[1].", ".$row[2].", ".$row[3].", ".$row[4].", ".$row[5].", ".$row[6].", ".$row[7].", ".$row[8].", ".$row[9].", ".$row[10].", ".$row[11];
                    if ($type == "stroom") {
                        $totaalVerbruik2 = round($row[12], 2). " kWh";
                    }else {
                        $totaalVerbruik2 = round($row[12], 2). " m3";
                    }
                }else {
                    //als de GET value fout is of niet klopt, laat dan de gegevens zien met de standaard values
                    header("Location: overzicht.php?jaar={$standaardJaar}&type={$standaardType}");
                    exit();
                }
            }
        }else {
            if($_GET['vergelijk'] == "true"){
                header("Location: overzicht.php?jaar={$minJaar}&type={$type}&vergelijk=true");
                exit();
            }else {
                header("Location: overzicht.php?jaar={$minJaar}&type={$type}");
                exit();
            }
        }
    
    
    }else {
        //als de GET value fout is of niet klopt, laat dan de gegevens zien met de standaard values
        header("Location: overzicht.php?jaar={$standaardJaar}&type={$standaardType}");
        exit();
    }
}

?>

<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energetiq :: Overzicht</title>
    <link rel="stylesheet" href="app/css/main.style.css">
    <link rel="stylesheet" href="app/css/overzicht.style.css">
    <link rel="icon" type="image/x-icon" href="app/img/icon.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
</head>
<body>
    <div class="grid-container">
        <header>
            <a href="index.php"><img src="app/img/logo.png" alt="energetiq" class="logo"></a>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="overzicht.php">Overzicht</a></li>
                    <li><a href="app/php/loguit.verwerk.php">Loguit</a></li>
                </ul>
            </nav>
        </header>
        <?php 
        if($heeftRecords) {
            ?>
            <main class="verbruikInfo">
                <div class="diagram">
                    <canvas id="myChart" style="width: 90%; height: 600px;"></canvas>
                </div>
                <div class="knoppen">
                    <select name="" id="typeSelect">
                        <?php
                            if($type == "stroom"){
                                ?>
                                <option value="stroom" selected>stroom</option>
                                <option value="gas">gas</option>
                                <?php
                            }else {
                                ?>
                                <option value="stroom">stroom</option>
                                <option value="gas" selected>gas</option>
                                <?php 
                            }
                        ?>
                    </select>
                    <br>
                    <select name="" id="jaarSelect">
                        <?php
                            foreach ($jaren as $value) {
                                if ($value == $jaar) {
                                    echo '<option value="'.$value.'" selected>'.$value.'</option>';
                                }else {
                                    echo '<option value="'.$value.'">'.$value.'</option>';
                                }
                            }
                        ?>
                    </select>
                    <br>
                    <?php
                        echo "<p>Jouw totaal verbruik van {$jaar}: ".$totaalVerbruik." </p>";
                        if (!isset($_GET['vergelijk'])) {
                            echo '<a href="overzicht.php?vergelijk=true&jaar='.$jaar.'&type='.$type.'">Vergelijk</a>';
                        }else {
                            echo "<p>Gemiddeld verbruik van huishoudens, {$jaar}: ".$totaalVerbruik2." </p><br>";
                            echo '<a href="overzicht.php?jaar='.$jaar.'&type='.$type.'">Stop vergelijking</a>';
                        }
                    ?>
                </div>
            </main>
            <?php
        }else {
            ?>
            <main class="geenRecords">
                <div class="melding">
                    <img src="app/img/low_battery.png" alt="low battery">
                    <p>Sorry, er staan nog geen gegevens in ons systeem</p>
                    <a href="index.php">Home</a>
                </div>
            </main>

            <?php
        }
        ?>
        <footer>
            <p>©Made by Kaylan</p>
        </footer>
    </div>
</body>
</html>



<script>
    var ctx = document.getElementById("myChart");
    <?php 
        if (isset($_GET['vergelijk'])) {
            ?>

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December"],
                    datasets: [
                        {
                        label: 'Jouw verbruik van maand',
                        data: [<?php echo $data; ?>],
                        backgroundColor: [
                            '#004e7e'
                        ],
                        borderColor: [
                            'rgb(0, 0, 0)'
                        ],
                        borderWidth: 1
                        ,
                        categoryPercentage: 0.5
                    },
                    {
                        label: 'Gemiddeld verbruik van maand',
                        data: [<?php echo $data2; ?>],
                        backgroundColor: [
                            '#3ACEB4'
                        ],
                        borderColor: [
                            'rgb(0, 0, 0)'
                        ],
                        borderWidth: 1
                    }
                
                ]
                },
                options: {
                    plugins: {
                    },
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: false
                        },
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });


            <?php
        }else {
            ?>

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December"],
                    datasets: [
                        {
                        label: 'Verbruik van maand',
                        data: [<?php echo $data; ?>],
                        backgroundColor: [
                            '#004e7e'
                        ],
                        borderColor: [
                            'rgb(0, 0, 0)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                        },
                    },
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: false
                        },
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });

            <?php
        }
            
    ?>
    let jaar = document.getElementById('jaarSelect');
    let type = document.getElementById('typeSelect');

    jaar.addEventListener('change', (event) => {
        let valueJ = jaar.options[jaar.selectedIndex].value;
        let valueT = type.options[type.selectedIndex].value;
        <?php 
            if(isset($_GET['vergelijk']) && $_GET['vergelijk'] == 'true') {
                ?>
                    window.location.href = "https://85734.ict-lab.nl/portfolio/projects/energie-website/overzicht.php?vergelijk=true&jaar="+valueJ+"&type="+valueT;
                <?php
            }else {
                ?>
                    window.location.href = "https://85734.ict-lab.nl/portfolio/projects/energie-website/overzicht.php?jaar="+valueJ+"&type="+valueT;
                <?php
            }
        
        ?>
    });

    type.addEventListener('change', (event) => {
        let valueJ = jaar.options[jaar.selectedIndex].value;
        let valueT = type.options[type.selectedIndex].value;
        <?php 
            if(isset($_GET['vergelijk']) && $_GET['vergelijk'] == 'true') {
                ?>
                    window.location.href = "https://85734.ict-lab.nl/portfolio/projects/energie-website/overzicht.php?vergelijk=true&jaar="+valueJ+"&type="+valueT;
                <?php
            }else {
                ?>
                    window.location.href = "https://85734.ict-lab.nl/portfolio/projects/energie-website/overzicht.php?jaar="+valueJ+"&type="+valueT;
                <?php
            }
        
        ?>
    });
</script>