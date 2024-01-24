<?php
    /*include the class connection.php*/
    include_once("includes/connection.php");
    $connessione = Connection::new();
    $userMail = $_POST['UserMail'];
    // Get UserMail from table Utenti
    $query = "SELECT email FROM utenti WHERE email = $userMail";
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
</head>
<body>
    <div class="item1">

    </div>

    <div class="item2">

    </div>

    <div class="item3">

    </div>
</body>
</html>

<?php
    }else{
        die();
    }
?>