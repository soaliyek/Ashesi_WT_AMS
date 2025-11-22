<?php

    session_start();

    if (!(isset($_SESSION["auth"]) && $_SESSION["auth"] === true)) {
        
        // Redirect based on role
        header("Location: ../bauthentication/usersignin.php");
        exit();
    }

    
?>