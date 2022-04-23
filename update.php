<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require 'app/php/config.php';
    include 'app/class/Klant.php';
    session_start();


    if (!isset($_GET['recordID']) || !isset($_GET['ID'])) {
        header("Location: index.php");
        exit();
    }else {
        $klantID = $_GET['ID'];
        $recordID = $_GET['recordID'];
        $query = "SELECT * FROM verbruik WHERE recordID = {$recordID}";
        $result = $conn->query($query);
        if($result->num_rows > 0) {
            $row = $result->fetch_array();
        }else {
            header("Location: beheer.php");
            exit();
        }
        
    }
?>


<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energetiq :: Update verbruik</title>
    <link rel="stylesheet" href="app/css/main.style.css">
    <link rel="stylesheet" href="app/css/verbruik.style.css">
    <script src="app/javascript/addField.js" defer></script>
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
            <div class="verbruikForm">
                <form action="app/php/update.verwerk.php" method="post">
                    <input type="hidden" name="klantID" value="<?php echo $row[1] ?>">
                    <input type="hidden" name="recordID" value="<?php echo $row[0] ?>">
                    <h3>Jaar: <?php echo $row[3] ?></h3>
                    <h3>Update verbruik per maand</h3>
                    <div id="wrapper">
                        <input type="number" name="maand1" value="<?php echo $row[4] ?>" autocomplete="off">
                        <input type="number" name="maand2" value="<?php echo $row[5] ?>" autocomplete="off">
                        <input type="number" name="maand3" value="<?php echo $row[6] ?>" autocomplete="off">
                        <input type="number" name="maand4" value="<?php echo $row[7] ?>" autocomplete="off">
                        <input type="number" name="maand5" value="<?php echo $row[8] ?>" autocomplete="off">
                        <input type="number" name="maand6" value="<?php echo $row[9] ?>" autocomplete="off">
                        <input type="number" name="maand7" value="<?php echo $row[10] ?>" autocomplete="off">
                        <input type="number" name="maand8" value="<?php echo $row[11] ?>" autocomplete="off"> 
                        <input type="number" name="maand9" value="<?php echo $row[12] ?>" autocomplete="off">
                        <input type="number" name="maand10" value="<?php echo $row[13] ?>" autocomplete="off">
                        <input type="number" name="maand11" value="<?php echo $row[14] ?>" autocomplete="off">
                        <input type="number" name="maand12" value="<?php echo $row[15] ?>" autocomplete="off">
                    </div>
                    <input type="submit" name="submit" value="Update">
                </form>
            </div>
        </main>
        <footer>
            <p>©Made by Kaylan</p>
        </footer>
    </div>
</body>
</html>


