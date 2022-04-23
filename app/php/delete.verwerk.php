<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';
session_start();

if(isset($_SESSION['ID']) && $_SESSION['rechten'] == 1 && isset($_GET['klantID'])) {
    $klantID = $_GET['klantID'];
    $gebruikerID = $_GET['gebruikerID'];
    //Delete eerst alle verbruik records
    $query1 = "DELETE FROM `verbruik` WHERE `klantID` = {$klantID}";
    $delete1 = $conn->query($query1);

    //Delete de klant dan in de klanten table
    $query2 = "DELETE FROM `klanten` WHERE `klantID` = {$klantID}";
    $delete2 = $conn->query($query2);

    //Delete de klant dan in de gebruikers table
    $query3 = "DELETE FROM `gebruikers` WHERE `gebruikerID` = {$gebruikerID}";
    $delete3 = $conn->query($query3);

    header("Location: ../../beheer.php");
    exit();
}else {
    header("Location: ../../index.php");
    exit();
}