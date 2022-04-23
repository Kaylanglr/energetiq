<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    $query = "SELECT * FROM gebruikers WHERE email = '{$email}'";
    $result = $conn->query($query);
    if($result) {
        if($result->num_rows > 0) {
            session_start();
            $row = $result->fetch_array();
            $_SESSION['email'] = $row[1];
            $_SESSION['rechten'] = $row[3];
            if ($row[3] == 0) {
                $query = "SELECT * FROM klanten WHERE gebruikerID = {$row[0]}";
            }else if ($row[3] == 1){
                $query = "SELECT * FROM medewerkers WHERE gebruikerID = {$row[0]}";
            }
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_array();
                $_SESSION['ID'] = $row[0];
                $_SESSION['naam'] = $row[2];
                header("Location: ../../index.php");
                exit();
            }
        }else {
            header("Location: ../../inlog.php?fout");
            exit();
        }
    }else {
        echo "query ging fout";
    }
}