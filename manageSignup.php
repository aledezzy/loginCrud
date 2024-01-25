<?php
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
    
    header("Location: login.php");
    exit();
?>