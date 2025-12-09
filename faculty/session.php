<?php
    session_start();

    if (!(isset($_SESSION["auth"]) && $_SESSION["auth"] === true)) {
        
        // Redirect
        header("Location: ../authentication/usersignin.php");
        exit();
    }else{
        // Redirect based on role
        if($_SESSION["role"] != "faculty"){
            switch($_SESSION["role"]) {
                case "student":
                    header("Location: ../student/courses.php");
                    exit();
                case "faculty":
                    header("Location: ../faculty/courses.php");
                    exit();
                case "admin":
                    header("Location: ../admin/courses.php");
                    exit();
            }
        }
    }

    include("../config/database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/dashboard.css">
    <title><?php echo $_SESSION['fName'] . " " . $_SESSION['lName'] . " - Dashboard" ?></title>
</head>
<body>
    <div id="dashboard">
        <?php include_once("../includes/fheader.php"); ?>
        <div id="main">
            <div id="allcourses" class="content">
                
            </div>
        </div>
    </div>
    <script src="../public/js/logout.js"></script>
</body>
</html>