<?php
    /*include the class connection.php*/
    include_once("includes/connection.php");
    $connessione = Connection::new();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="styles/style.css" rel="stylesheet" />
</head>
<body>
<div class="fullViewport flex" style="flex-direction:column;">
    <header>
        <nav>
        <ul class="flex" style="list-style-type:none; gap:1em; align-items:center;">
            <li><img src="images/header-logo.svg" alt=""></li>
            <li><a class="no-dec" href="index.php">Home</a></li>
            <li><a class="no-dec" href="login.php">Accedi</a></li>
            <li><a class="no-dec" href="signup.php">Registrati</a></li>
        </ul> 
        </nav>
    </header>
    <div class="dashBoardGrid" style="flex-grow : 1;">
        <div id="userGrid"></div>
        <div id="bookGrid"></div>
        <div id="managementGrid"></div>
    </div>
</div>
</body>
</html>