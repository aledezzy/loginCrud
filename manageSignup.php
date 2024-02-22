<?php
/*include the class connection.php*/
include 'includes/connection.php';
$connessione = Connection::new();

//start the session
session_start();
// Get UserMail from table Utenti

if (isset($_POST["isNewUser"])) {
    $userName = $_POST['UserName'];
    $userSurname = $_POST['UserSurname'];
    $userMail = $_POST['UserMail'];
    $userPassword = $_POST['UserPWD'];
    //hash the password
    $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

}
//insert the post values into the db utenti
$query = "INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)";
$preparedQuery = $connessione->prepare($query);
$preparedQuery->bind_param("ssss", $userName, $userSurname, $userMail, $userPassword);
$preparedQuery->execute();
/*$preparedQuery->bind_result($userMail, $userMail, $userPassword, $userPassword);
$preparedQuery->execute();
$preparedQuery->store_result();
$preparedQuery->close();*/

//si potrebbero inserire in un if
$_SESSION['user'] = $userMail; // imposta la variabile di sessione
$_SESSION['role'] = 'user'; // imposta la variabile di sessione
?>
<script>
    alert("Registrazione avvenuta con successo.");
    window.location.href = "login.php";
</script>
<?php

die();

?>