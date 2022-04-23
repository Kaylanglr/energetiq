<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'config.php';

if(isset($_POST['submit'])) {
    $totaalVerbruik = 0;
    $klantID = $_POST['ID'];
    $type = $_POST['type'];
    $jaar = $_POST['year'];
    $values = array();
    for($i = 1; $i <= 12; $i++) {
        echo $_POST["maand{$i}"]."<br>";

        if($_POST["maand{$i}"] != null) {
            array_push($values, $_POST["maand{$i}"]);
        }else {
            array_push($values, 0);
        }
    }
    for($i = 0; $i < count($values); $i++) {
        $totaalVerbruik += $values[$i];
    }

    $query = "INSERT INTO verbruik (`klantID`, `type`, `jaar`, `januari`, `februari`, `maart`, `april`, `mei`, `juni`, `juli`, `augustus`, `september`, `oktober`, `november`, `december`, `totaalVerbruik`) VALUES ({$klantID}, '{$type}', {$jaar}, {$values[0]}, {$values[1]}, {$values[2]}, {$values[3]}, {$values[4]}, {$values[5]}, {$values[6]}, {$values[7]}, {$values[8]}, {$values[9]}, {$values[10]}, {$values[11]}, {$totaalVerbruik})";

    $result = $conn->query($query);
    if($result) {
        header("Location: ../../klantRecords.php?ID={$klantID}"); 
        exit();
    }else {
        header("Location: ../../index.php");
        exit();
    }
}