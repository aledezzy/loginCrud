<?php
/*include the class connection.php*/
include 'includes/connection.php';
//start the session
session_start();
if (isset($_SESSION['user'])) {
    if ($_SESSION['role'] == "admin") {
        header("Location: dashboardAmministratori.php");
        die();
    }
}else{
    header("Location: login.php");
    die();
}
?>
    <!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utenti</title>
    <link href="styles/dashboard.css" rel="stylesheet" />
    <script src="script/divSelector.js"></script>
</head>

<body>
    <div class="sidebarGridTemplate"
    id="dashboardSidebar">
        <button class="sidebarButton" onclick="showDiv(1)">Button 1</button>
        <button class="sidebarButton" onclick="showDiv(2)">Button 2</button>
        <button class="sidebarButton" onclick="showDiv(3)">Button 3</button>
    </div>

    <div class="itemsMargin flex" id="dashboardHeader" style="justify-content: end;">
        <div class=" flex center">
            <div class="flex logoutButton">
            <img src="images/logoutLogo.svg" alt="headedrLogo">
            <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>



    <main>
        <div class="itemsMargim" style="height:100%" id="dashboardMainContent" style="height:inherit;">
             <div id="div0" class="defaultPanel content-div">
                <h1>School dashboard</h1>
                <p>by De Zuani, Calizzano & Morabito<p>
                <p style="color:#2563eb;">Seleziona un'opzione</p>
             </div>

            <div id="div1" class="content-div gridTemplate parentHeight gridCenter">
            <div class="item"></div>
            <div class="item"></div>
            <div class="item"></div>
            <div class="item"></div>
            </div>

        <div id="div2" class="content-div gridTemplate parentHeight gridCenter">
            <div class="item"></div>
            <div class="item"></div>
            <div class="item"></div>
            <div class="item"></div>
        </div>

        <div id="div3" class="content-div gridTemplate parentHeight gridCenter">
            <div class="item"></div>
            <div class="item"></div>
            <div class="item">

            </div>
            <div class="item">

            </div>
        </div>
    </div>
    </div>

        </div>
    </main>
        
</body>
</html>
