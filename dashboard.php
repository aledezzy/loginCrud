<?php
    /*include the class connection.php*/
    include_once("includes/connection.php");
    $connessione = Connection::new();
    $userMail = $_POST['UserMail'];
    // Get UserMail from table Utenti
    $query = "SELECT email FROM utenti WHERE email = '".$userMail."'";
    $result = $connessione->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userMail = $row['email'];
            // Use the UserMail as needed
        }
    
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="styles/dashboard.css" rel="stylesheet" />
    <script src="script/divSelector.js"></script>
</head>
<body>
    <div class="itemsMargin" id="dashboardSidebar">
        <button onclick="showDiv(1)">Button 1</button>
        <button onclick="showDiv(2)">Button 2</button>
        <button onclick="showDiv(3)">Button 3</button>
    </div>

    <div class="itemsMargin" id="dashboardHeader">

    </div>

    <main class="itemsMargin" id="dashboardMainContent">  
        <div id="div1" class="content-div gridTemplate">
            <div class="item">

            </div>
            <div class="item">

            </div>
            <div class="item">

            </div>
            <div class="item">

            </div>
        </div>

        <div id="div2" class="content-div gridTemplate">
            <div class="item">
            </div>

            <div class="item">
            </div>

            <div class="item">
            </div>

            <div class="item">
            </div>
        </div>

        <div id="div3" class="content-div gridTemplate">
            <div class="item">
            </div>
            <div class="item">

            </div>
            <div class="item">

            </div>
            <div class="item">

            </div>
        </div>
    </main>
</body>
</html>

<?php
    }else{
        die();
    }
?>