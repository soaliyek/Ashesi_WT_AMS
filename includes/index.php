<?php

    session_start();

    if (isset($_SESSION["auth"]) && $_SESSION["auth"] === true) {
        
        // Redirect based on role
        switch($_SESSION["role"]) {
            case "student":
                header("Location: ../student/dashboard.php");
                exit();
            case "faculty":
                header("Location: ../faculty/dashboard.php");
                exit();
            case "admin":
                header("Location: ../admin/dashboard.php");
                exit();
        }
    }

    header("Location: bauthentication/usersignup.php");
    exit();
?>