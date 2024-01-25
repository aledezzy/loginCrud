<?php
/*include the class connection.php*/
include 'includes/connection.php';
//prendere i dati dal form
$userMail = $_POST['UserMail'];
$userPassword = $_POST["UserPWD"];


echo "<h1>sono PAZZO manageLogin</h1>";
$connessione = Connection::new();
echo "<h2>sono PAZZO manageLogin</h2>";
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

?>