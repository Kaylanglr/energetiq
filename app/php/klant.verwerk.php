<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';
include '../class/Klant.php';


if(isset($_POST['submit'])) {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $straat = $_POST['straat'];
    $huisnummer = $_POST['huisnummer'];
    $postcode = $_POST['postcode'];
    $plaats = $_POST['plaats'];

    $klant = new Klant($naam, $email, $wachtwoord, $telefoonnummer, $straat, $huisnummer, $postcode, $plaats);
    
    if($klant->insertKlant($conn)) {
        header("Location: ../../beheer.php");
        exit();
    }else {
        echo "error";
    }

}else if (isset($_GET['action']) && $_GET['action'] == 'delete') {

}else {
    header("Location: ../../beheer.php");
    exit();
}