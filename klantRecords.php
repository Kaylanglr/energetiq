<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();

    require 'app/php/config.php';
    include 'app/class/Klant.php';

    $gegevens = true;

    if(!isset($_SESSION['ID']) || $_SESSION['rechten'] != 1) {
        header("Location: index.php");
        exit();
    }

    if(!isset($_GET['ID'])) {
        header("Location: beheer.php");
        exit();
    }
    $klantID = $_GET['ID'];
    $query = "SELECT * FROM verbruik WHERE klantID = {$klantID}";
    $result = $conn->query($query);
    if($result->num_rows <= 0) {
        $gegevens = false;
    }

?>

<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energetiq :: Records</title>
    <link rel="stylesheet" href="app/css/main.style.css">
    <link rel="stylesheet" href="app/css/records.style.css">
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
            <?php
            if($gegevens == true) {
                ?>  
                    <a href="beheer.php" class="back-btn">Ga terug</a>
                    <table>
                        <thead>
                            <th>Jaar</th>
                            <th>Type</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php 
                            while($row = $result->fetch_array()) {
                                ?>
                                <tr>
                                    <td><?php echo $row[3] ?></td>
                                    <td><?php echo $row[2] ?></td>
                                    <td><a href="update.php?recordID=<?php echo $row[0] ?>&ID=<?php echo $klantID ?>">Update</a></td>
                                    <td><a href="app/php/deleteRecord.verwerk.php?recordID=<?php echo $row[0] ?>&ID=<?php echo $klantID ?>">Delete</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
            }else {
                ?>
                    <h3>Geen records gevonden</h3>
                    <a href="beheer.php" class="back-btn">Ga terug</a>
                <?php
            }

            ?>
        </div>
        </main>
        <footer>
            <p>©Made by Kaylan</p>
        </footer>
    </div>
</body>
</html>