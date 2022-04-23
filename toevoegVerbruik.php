<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require 'app/php/config.php';
    include 'app/class/Klant.php';
    session_start();


    if (!isset($_GET['klantID']) || !isset($_GET['type'])) {
        header("Location: index.php");
        exit();
    }else {
        $jaren = [2019, 2020, 2021, 2022];
        $type = $_GET['type'];
        $klantID = $_GET['klantID'];
        $query = "SELECT * FROM klanten WHERE klantID = {$klantID}";
        $controlle = $conn->query($query);
        if ($controlle->num_rows > 0) {
            $query2 = "SELECT * FROM verbruik WHERE klantID = {$klantID} AND `type` = '{$type}'";
            $result = $conn->query($query2);
            if($result->num_rows > 0){
                while ($row = $result->fetch_array()) {
                    if (($key = array_search($row[3], $jaren)) !== false) {
                        unset($jaren[$key]);
                    }     
                }
            }
        }else {
            header("Location: index.php");
            exit();
        }
    }
?>


<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energetiq :: Voeg verbruik toe</title>
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
                <form action="app/php/verbruik.verwerk.php" method="post">
                    <input type="hidden" name="ID" value="<?php echo $klantID; ?>">
                    <input type="hidden" name="type" value="<?php echo $type; ?>">
                    <select id="year" name="year" required>
                        <option value="" selected disabled>Selecteer een jaar</option>
                        <?php
                        foreach ($jaren as $value) {
                            ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <h3>Voer verbruik per maand in</h3>
                    <div id="wrapper">
                        <input type="number" name="maand1" placeholder="Januari" autocomplete="off">
                        <input type="number" name="maand2" placeholder="Februari" autocomplete="off">
                        <input type="number" name="maand3" placeholder="Maart" autocomplete="off">
                        <input type="number" name="maand4" placeholder="April" autocomplete="off">
                        <input type="number" name="maand5" placeholder="Mei" autocomplete="off">
                        <input type="number" name="maand6" placeholder="Juni" autocomplete="off">
                        <input type="number" name="maand7" placeholder="Juli" autocomplete="off">
                        <input type="number" name="maand8" placeholder="Augustus" autocomplete="off"> 
                        <input type="number" name="maand9" placeholder="September" autocomplete="off">
                        <input type="number" name="maand10" placeholder="Oktober" autocomplete="off">
                        <input type="number" name="maand11" placeholder="November" autocomplete="off">
                        <input type="number" name="maand12" placeholder="December" autocomplete="off">
                    </div>
                    <input type="submit" name="submit" value="submit">
                </form>
            </div>
        </main>
        <footer>
            <p>©Made by Kaylan</p>
        </footer>
    </div>
</body>
</html>


