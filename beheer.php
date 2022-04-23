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

    $query = "SELECT gebruikers.gebruikerID, klantID, naam, email, telefoonnummer, straat, huisnummer, postcode, plaats FROM klanten INNER JOIN gebruikers ON klanten.gebruikerID = gebruikers.gebruikerID";
    $result = $conn->query($query);
?>


<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energetiq :: Beheer</title>
    <link rel="stylesheet" href="app/css/main.style.css">
    <link rel="stylesheet" href="app/css/beheer.style.css">
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
                    <li><a href="toevoegKlant.php">Voeg klant toe</a></li>
                    <li><a href="app/php/loguit.verwerk.php">Loguit</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <?php 
                while ($row = $result->fetch_array()) {
                    ?>
                        <div class="klantKaart">
                            <ul>
                                <li><i class="fa-solid fa-user"></i> <?php echo $row[2]; ?></li>
                                <li><i class="fa-solid fa-at"></i> <?php echo $row[3]; ?></li>
                                <li><i class="fa-solid fa-phone"></i> <?php echo $row[4]; ?></li>
                                <li><i class="fa-solid fa-location-dot"></i> <?php echo $row[5]." ".$row[6].", ".$row[7]." ".$row[8]; ?></li>
                            </ul>
                            <p class="p1">Records</p>
                            <a href="klantRecords.php?ID=<?php echo $row[1]; ?>" class="knop records">Records</a>
                            <p class="p2">Voeg verbruik toe</p>
                            <a href="toevoegVerbruik.php?klantID=<?php echo $row[1]; ?>&type=gas" class="knop gas">gas</a>
                            <a href="toevoegVerbruik.php?klantID=<?php echo $row[1]; ?>&type=stroom" class="knop stroom">stroom</a>
                            <a href="app/php/delete.verwerk.php?klantID=<?php echo $row[1]; ?>&gebruikerID=<?php echo $row[0]; ?>" class="knop delete">delete</a>
                        </div>
                    <?php
                }
            ?>
        </main>
        <footer>
            <p>©Made by Kaylan</p>
        </footer>
    </div>
</body>
</html>
<script src="https://kit.fontawesome.com/ab1ca9801d.js" crossorigin="anonymous"></script>