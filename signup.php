<?php
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="styles/style.css" rel="stylesheet" />
</head>
<body>
<div class="fullViewport flex flex-center">
            <form class="loginBoard flex flex-center" action="manageSignup.php" method="post" class="loginPage">

                <img style="display:inline; height:64px; width:64px;" src="images/newUserIMG.svg" alt="UserIMG">

                <div class="flex" style="gap : 1em;">
                    <div class="fullWidth">
                        <p style="margin-bottom:5px;">Nome</p>
                        <input class="loginButton loginBorder" type="text" name="UserName"></input>
                    </div>

                    <div class="fullWidth">
                        <p style="margin-bottom:5px;">Cognome</p>
                        <input class="loginButton loginBorder" type="text" name="UserSurname"></input>
                    </div>
                </div>

                <div class="fullWidth">
                    <p style="margin-bottom:5px;">E-mail</p>
                    <input class="loginButton loginBorder" type="email" name="UserMail"></input>
                </div>

                <div class="fullWidth">
                    <p style="margin-bottom:5px;">Password</p>
                    <input  class="loginButton loginBorder" type="password" name="UserPWD"></input>
                </div>

                <input  class="submitButton loginBorder" type="submit"  value="Registrati"></input>
                <input  type="hidden"  name="isNewUser" value="true">
            </form>
        </div>

</body>
</html>