<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'config.php';

if(isset($_POST['submit'])) {
    $totaalVerbruik = 0;
    $recordID = $_POST['recordID'];
    $klantID = $_POST['klantID'];
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

    
    $query = "UPDATE verbruik SET `januari` = {$values[0]}, `februari` = {$values[1]}, `maart` = {$values[2]}, `april` = {$values[3]}, `mei` = {$values[4]}, `juni` = {$values[5]}, `juli` = {$values[6]}, `augustus` = {$values[7]}, `september` = {$values[8]}, `oktober` = {$values[9]}, `november` = {$values[10]}, `december` = {$values[11]}, `totaalVerbruik` = {$totaalVerbruik} WHERE `recordID` = {$recordID}";
    

    $result = $conn->query($query);
    if($result) {
        header("Location: ../../klantRecords.php?ID={$klantID}"); 
        exit();
    }else {
        header("Location: ../../index.php");
        exit();
    }
}