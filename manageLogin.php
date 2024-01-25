<?php
//prendere i dati dal form
$userMail = $_POST['UserMail'];
$userPassword = $_POST['UserPWD'];
//hash the password
$userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

echo "sono in manageLogin";
/*include the class connection.php*/
$connessione = Connection::new();
$searchUserQuery = "SELECT email, password FROM utenti WHERE email = '" . $userMail . "'";
$result = $connessione->query($searchUserQuery);
$row = $result->fetch_assoc();
if ($result->num_rows == 0 ) {
    echo "Utente non trovato";
    //redirect to signup.php
    header('Location: signup.php');
    die();

}else{
    echo "Utente trovato";
    
    //controllo password proveniente dal form 
    if (!password_verify($userPassword, $row['password'])) {
        echo "Password errata";
        //redirect to login.php
        header("Location: login.php");
        exit();
    } else {
        echo "Password corretta";
        $query = "SELECT password, ruolo FROM utenti WHERE email = '" . $userMail . "'";
        $ruolo = $connessione->query($query);
        $row = $ruola->fetch_assoc();
        if ($row['ruolo'] == "admin") {
            echo "sei un amministratore";
            //redirect to dashboardAmministratori.php
            header('Location: dashboardAmministratori.php');
            exit();
        } else {
            //redirect to dashboardUtenti.php
            header("Location: dashboardUtenti.php");
            exit();
        }
    }
}


if ($result->num_rows > 0 ) {
    

}

?>