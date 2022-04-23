<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';


if(isset($_GET['recordID'])) {
    $klantID = $_GET['ID'];
    $recordID = $_GET['recordID'];
    $query = "DELETE FROM `verbruik` WHERE `recordID` = {$recordID}"; 
    $result = $conn->query($query);
    header("Location: ../../klantRecords.php?ID={$klantID}"); 
    exit();
}