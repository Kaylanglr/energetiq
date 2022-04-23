<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();

    require 'app/php/config.php';
    include 'app/class/Klant.php';

    if(!isset($_SESSION['ID']) || $_SESSION['rechten'] != 1) {
        header("Location: index.php");
        exit();
    }
?>


<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energetiq :: Voeg klant toe</title>
    <link rel="stylesheet" href="app/css/main.style.css">
    <link rel="stylesheet" href="app/css/klant.style.css">
    <link rel="icon" type="image/x-icon" href="app/img/icon.png">
</head>
<body>
    <div class="grid-container">
        <header>
            <a href="index.php"><img src="app/img/logo.png" alt="energetiq" class="logo"></a>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="beheer.php">Beheer</a></li>
                    <li><a href="app/php/loguit.verwerk.php">Loguit</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div>
                <form action="app/php/klant.verwerk.php" method="POST">
                    <input type="text" name="naam" placeholder="Naam...." required autocomplete="off">
                    <input type="email" name="email" placeholder="Email..." required autocomplete="off">
                    <input type="password" name="wachtwoord" placeholder="Wachtwoord..." required autocomplete="off">
                    <input type="number" name="telefoonnummer" placeholder="Telefoonnummer..." required autocomplete="off">
                    <input type="text" name="straat" placeholder="Straat..." required autocomplete="off">
                    <input type="text" name="huisnummer" placeholder="Huisnummer..." required autocomplete="off">
                    <input type="text" name="postcode" placeholder="Postcode..." required autocomplete="off">
                    <input type="text" name="plaats" placeholder="Plaats..." required autocomplete="off">
                    <input type="submit" name="submit" value="Voeg toe">
                </form>
            </div>
        </main>
        <footer>
            <p>©Made by Kaylan</p>
        </footer>
    </div>
</body>
</html>


