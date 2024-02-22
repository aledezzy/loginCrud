<?php
   
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="styles/style.css" rel="stylesheet" />
</head>
<body>
        <div class="fullViewport flex flex-center">
            <form class="loginBoard flex flex-center" action="manageLogin.php" method="post" class="loginPage">
 
                <img style="display:inline; height:64px; width:64px;"src="images/userBadge.svg" alt="UserIMG">

                <div class="fullWidth">
                <p style="margin-bottom:5px;">E-mail</p>
                <input class="loginButton loginBorder" type="text" name="UserMail"></input>
                </div>

                <div class="fullWidth">
                <p style="margin-bottom:5px;">Password</p>
                <input  class="loginButton loginBorder" type="password" name="UserPWD"></input>
                </div>
                <input  class="submitButton loginBorder" type="submit"  value="Accedi"></input>
                <p class="UnregisteredButton" style="margin-left: auto;">
                    <a href="signup.php" >Non sei un utente registrato?</a>
                </p>
            </form>
        </div>

</body>
</html>
