<?php
echo "ciaoffsffbdfbfb";
/*include the class connection.php*/
$connessione = Connection::new();

// Get UserMail from table Utenti

if (isset($_POST["isNewUser"])) {
    $userName = $_POST['UserName'];
    $userSurname = $_POST['UserSurname'];
    $userMail = $_POST['UserMail'];
    $userPassword = $_POST['UserPWD'];
    //hash the password
    $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    //insert the post values into the database
    $query = "INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)";
    $preparedQuery = $connessione->prepare($query);
    $preparedQuery->bind_param("ssss", $userName, $userSurname, $userMail, $userPassword);
    $preparedQuery->execute();
    $preparedQuery->bind_result($userMail, $userMail, $userMail, $userPassword);
    $preparedQuery->execute();
    $preparedQuery->store_result();
    
    //show error if query is not executed
    if ($preparedQuery->errno) {
        echo "Query non eseguita, errore: " . $preparedQuery->error;
    } else {
        echo "Query eseguita con successo";
    }
}   

$query = "SELECT email, password FROM utenti WHERE email = '" . $userMail . "'";
$result = $connessione->query($query);

if ($result->num_rows > 0 ) {
    while ($row = $result->fetch_assoc()) {
        $userMail = $row['email'];
        
    }
    if (password_verify($userPassword, $row['password'])) {
        echo "Password corretta";
    } else {
        echo "Password errata";
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

        <div class="itemsMargin" id="dashboardHeader">

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

    <?php
} else {
    echo 'vdndnnd';
    include("signup.php");}
    ?>
   
   