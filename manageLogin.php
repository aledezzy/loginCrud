<?php
//start the session
session_start();
if ($_SESSION['userRole'] == "admin") {
    header('Location: dashboardAmministratori.php');
    exit();
} else if ($_SESSION['userRole'] == "admin"){
    header("Location: dashboardUtenti.php");
    exit();
} else if(!isset($_SESSION['userRole'])){
    header("Location: signup.php");
    exit();
}
/*include the class connection.php*/
include 'includes/connection.php';
//prendere i dati dal form
$userMail = $_POST['UserMail'];
$userPassword = $_POST["UserPWD"];
$criptedUserPassword = password_hash($userPassword, PASSWORD_DEFAULT);
//hash the password
//$userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

echo "<h1>sono in manageLogin</h1>";
$connessione = Connection::new();
$searchUserQuery = "SELECT email, password, ruolo FROM utenti WHERE email = '".$userMail."'";
$result = $connessione->query($searchUserQuery);



if ($result->num_rows == 0) {
    echo "Utente non trovato";
    //redirect to signup.php
    header('Location: signup.php');
    die();
}else{
    while ($row = $result->fetch_assoc()) {
        $_SESSION['userRole'] = $row['ruolo'];
    }
}
$result->free_result();

//Query for getting the role of an user
/**
 * $searchRolequery = "SELECT ruolo FROM utenti WHERE email = '" . $userMail . "'";
$result = $connessione->query($searchRolequery);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userRole = $row['ruolo'];
    }
}
 */

if (!(password_hash($userPassword, PASSWORD_DEFAULT)  == $criptedUserPassword)) {
    echo "Password errata";
    //redirect to login.php
    header("Location: login.php");
    exit();
} else {
    echo "Password corretta";
    if ($userRole == "admin") {
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
$connessione->close();

/** 
 * if ($result->num_rows == 0 ) {
 echo "Utente non trovato";
 //redirect to signup.php
 header('Location: signup.php');
 die();
 
}else{
    echo "Utente trovato";
    
    //controllo password proveniente dal form 
    if (!(password_verify($userPassword, $criptedUserPassword))) {
        echo "Password errata";
        //redirect to login.php
        echo '<script>alert(Password errata, ritentare)</script>'; 

        header("Location: includes/ERROR.php");
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

 */ 
?>