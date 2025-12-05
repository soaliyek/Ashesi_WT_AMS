<?php

    session_start();

    if (isset($_SESSION["auth"]) && $_SESSION["auth"] === true) {
        
        // Redirect based on role
        switch($_SESSION["role"]) {
            case "student":
                header("Location: student/courses.php");
                exit();
            case "faculty":
                header("Location: faculty/courses.php");
                exit();
            case "admin":
                header("Location: admin/courses.php");
                exit();
        }
    }

    header("Location: authentication/usersignup.php");
    exit();
?>