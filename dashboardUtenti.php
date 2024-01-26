<?php
    
    include 'includes/connection.php';
    //start session and check for variable 'userRole'
    session_start();
    //check if the user is logged in, if not then redirect him to login page. Check also if the user is an admin or a user
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        die();
    } else {
        if ($_SESSION['userRole'] == "admin") {
            header("Location: dashboardAmministratori.php");
            die();
        }
    }
?>
    <!DOCTYPE html>
    <html lang="it">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="styles/dashboard.css" rel="stylesheet" />
        <script src="script/divSelector.js"></script>
    </head>

    <body>
        <h1>Ciao</h1>
        <div class="itemsMargin" id="dashboardSidebar">
            <button onclick="showDiv(1)">Button 1</button>
            <button onclick="showDiv(2)">Button 2</button>
            <button onclick="showDiv(3)">Button 3</button>
        </div>

        <div class="itemsMargin" style="display:flex; justify-content:end;"id="dashboardHeader">
            <div style="background-color: red; width:30%">
                <a href="logout.php">Logout<a>
            </div>
        </div>



        <div class="itemsMargin" id="dashboardMainContent" style="height:inherit;">
            <div id="div1" class="content-div gridTemplate parentHeight gridCenter">
                <div class="item">
                    <h1 style="color: blue;">dddd</h1>
                </div>
                <div class="item">

                </div>
                <div class="item">

                </div>
                <div class="item">

                </div>
            </div>

            <div id="div2" class="content-div gridTemplate parentHeight gridCenter">
                <div class="item">
                    <h1 style="color: blue;">gggg</h1>
                </div>
                <div class="item">

                </div>
                <div class="item">

                </div>
                <div class="item">

                </div>
            </div>

            <div id="div3" class="content-div gridTemplate parentHeight gridCenter">
                <div class="item">
                    <h1 style="color: blue;">vbvbbbbb</h1>
                </div>
                <div class="item">

                </div>
                <div class="item">

                </div>
                <div class="item">

                </div>
            </div>
        </div>
        </body>

</html>
