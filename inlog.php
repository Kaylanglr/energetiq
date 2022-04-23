<?php
    session_start();
    if(isset($_SESSION['ID'])) {
        header("Location: index.php");
        exit();
    }
?>

<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energetiq :: Login</title>
    <link rel="stylesheet" href="app/css/main.style.css">
    <link rel="stylesheet" href="app/css/login.style.css">
    <link rel="icon" type="image/x-icon" href="app/img/icon.png">
</head>
<body>
    <div class="grid-container">
        <header>
            <a href="index.php"><img src="app/img/logo.png" alt="energetiq" class="logo"></a>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="inlog.php">Login</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div>
                <p>Login</p>
                <form action="app/php/login.verwerk.php" method="post">
                    <input type="email" name="email" placeholder="Email...." autocomplete="off" required>
                    <br>
                    <input type="password" name="wachtwoord" placeholder="Wahtwoord..." autocomplete="off" required>
                    <br>
                    <?php 
                    if(isset($_GET['fout'])){
                        ?>
                        <span class="melding">email of wachtwoord is onjuist!</span>
                        <br>
                        <?php
                    }
                    ?>
                    <input type="submit" name="submit" value="login">
                </form>
                <p class="loginInfo">Klan: WW = #1Geheim / Email = test1@gmail.com</p>
                <p class="loginInfo">Beheerder: WW= #1Geheim / Email = 85734@glr.nl</p>
            </div>
        </main>
        <footer>
            <p>©Made by Kaylan</p>
        </footer>
    </div>
</body>
</html>