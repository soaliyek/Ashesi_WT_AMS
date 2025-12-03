<?php
    session_start();

    if (!(isset($_SESSION["auth"]) && $_SESSION["auth"] === true)) {
        
        // Redirect
        header("Location: ../authentication/usersignin.php");
        exit();
    }else{
        // Redirect based on role
        if($_SESSION["role"] != "student"){
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
    }

    include("../config/database.php");
    include_once("../sql/queries.php");

    $courses = $connection->query($findallcourses);
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
        <header>
            <nav>
                <a href="" id="mycourses">
                    <p>My Cources</p>
                </a>
                <a href="" id="courses">
                    <p>Courses</p>
                </a>
                <a href="" id="enrollments">
                    <p>Enrollments</p>
                </a>
            </nav>
            <div id="profile">
                <div id="picture">
                    <img src="../public/images/profile.png" alt="" srcset="">
                </div>
                <div id="text">
                    <p class="bold"> <?php echo $_SESSION['role'] ?></p>
                    <p><?php echo $_SESSION['fName'] . " " . $_SESSION['lName']  ?></p>
                </div>
            </div>
            <div id="siguout">
                <button type="button" onclick="logout()">Logout</button>
            </div>
        </header>
        <div id="main">
            <div id="allmycourses" class="content">
                <h1>Student</h1>
            </div>
            <div id="allcourses" class="content">
                <?php while($course = $courses->fetch_assoc()): ?>
                    <div class="course">
                        <p> <b><?= $course['courseCode']; ?></b> <?= $course['courseName']; ?> </p>
                    </div>
                <?php endwhile; ?>
            </div>
            <div id="allmyenrolments" class="content">
                
            </div>
        </div>
    </div>
    <script src="../public/js/logout.js"></script>
</body>
</html>