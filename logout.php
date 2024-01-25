<?php
    //destroy the session to logout user
    session_destroy();
    //redirect to login.php
    header("Location: login.php");
    die()
?>
