<?php
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
            <form class="loginBoard flex flex-center" action="dashboard.php" method="post" class="loginPage">
                    <img style="display:inline; height:64px; width:64px;" src="images/newUserIMG.svg" alt="UserIMG">
                <div class="fullWidth">
                <p style="margin-bottom:5px;">Nome Utente</p>
                <input class="loginButton loginBorder" type="text" name="UserID"></input>
                </div>

                <div class="fullWidth">
                <p style="margin-bottom:5px;">Password</p>
                <input  class="loginButton loginBorder" type="text" name="UserPWD"></input>
                </div>

                <input  class="submitButton loginBorder" type="submit"  value="Accedi"></input>
            

            </form>
        </div>

</body>
</html>