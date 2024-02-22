<?php

/*include the class connection.php*/
include 'includes/connection.php';
//start the session
session_start();
//check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION['user'])) {
    if ($_SESSION['role'] == "admin") {
        header("Location: dashboardAmministratori.php");
        die();
    } else {
        header("Location: dashboardUtenti.php");
        die();
    }
}

$connessione = Connection::new();


//prendere i dati dal form
$userMail = $_POST['UserMail'];
$userPassword = $_POST["UserPWD"];

$isDisableQuery = "SELECT stato FROM utentidisabilitati WHERE email = '".$userMail."'";
$result = $connessione->query($isDisableQuery);
if ($result->num_rows == 1) {
    echo "Utente disabilitato";
    header("Location: ./includes/DISABLED.html");
?>
    
    
<?php
    die();
}
$result->free_result();

$searchUserQuery = "SELECT email, password, ruolo FROM utenti WHERE email = '" . $userMail . "'";
echo "<h1>ao</h1>";
$result = $connessione->query($searchUserQuery);

echo "<h1>ao</h1>";

if ($result->num_rows == 0) {
    echo "Utente non trovato";
    //redirect to signup.php
    header("Location: includes/ERROR.php");
    die();
} else {
    echo "<h1>utente trovato</h1>";
    while ($row = $result->fetch_assoc()) {
        $userRole = $row['ruolo'];
    }
    
}

echo "<h1>ehm</h1>";

//query for getting the password from the db
$searchPasswordQuery = "SELECT password FROM utenti WHERE email = '" . $userMail . "'";
$result = $connessione->query($searchPasswordQuery);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $criptedPassword = $row['password'];
    }
}
//query for getting the role of an user
$searchRolequery = "SELECT ruolo FROM utenti WHERE email = '" . $userMail . "'";
$result = $connessione->query($searchRolequery);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userRole = $row['ruolo'];
    }
}
echo "<h1>adesso verifico la password</h1>";
if (!(password_verify($userPassword, $criptedPassword))) {
    echo "Password errata";
    //redirect to login.php
    header("Location: includes/ERROR.php");
    exit();
} else {
    echo "Password corretta";
    $_SESSION['user'] = $userMail; // imposta la variabile di sessione
    $_SESSION['role'] = $userRole; // imposta la variabile di sessione
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

?>
