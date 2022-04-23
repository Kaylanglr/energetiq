<?php
session_start();
?>

<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom bij Energetiq</title>
    <link rel="stylesheet" href="app/css/main.style.css">
    <link rel="stylesheet" href="app/css/index.style.css">
    <link rel="icon" type="image/x-icon" href="app/img/icon.png">
</head>
<body>
    <div class="grid-container">
        <header>
            <a href="index.php"><img src="app/img/logo.png" alt="energetiq" class="logo"></a>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <?php
                    if(isset($_SESSION['ID'])) {
                        if($_SESSION['rechten'] == 1) {
                            echo '<li><a href="beheer.php">Beheer</a></li>';
                        }
                        else if($_SESSION['rechten'] == 0) {
                            echo '<li><a href="overzicht.php">Overzicht</a></li>';
                        }
                        echo '<li><a href="app/php/loguit.verwerk.php">Loguit</a></li>';
                    }else {
                        echo '<li><a href="inlog.php">Login</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </header>
        <main>
            <div class="home">
                <div class="image">
                    <img src="app/img/lightbulb.png" alt="">
                </div>
                <div class="info">
                    <p>
                        Welkom bij energetiq, als duurzame energieleverancier leveren we 100% groene stroom uit eigen land. En we helpen je energie te besparen.
                        <br><br>
                        Op deze website kun je het verbruik van de afgelopen jaren in een mooi overzicht zien. 
                        Ook kun je vergelijken met andere huishoudens om te zien of je teveel verbruikt of te weinig.
                        <br><br>
                        <a href="overzicht.php">Bekijk je verbruik</a><br>
                        Bekijk je energieverbruik en begin vandaag nog met besparen.
                    </p>
                </div>
            </div>
        </main>
        <footer>
            <p>©Made by Kaylan</p>
        </footer>
    </div>
</body>
</html>