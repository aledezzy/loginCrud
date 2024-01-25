<?php
    //unset all the global variable of session
    session_start();
    session_unset();
    session_destroy();

    //redirect to login.php
    header("Location: login.php");
    die();
