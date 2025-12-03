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
    <title><?php echo $_SESSION['fName'] . " " . $_SESSION['lName'] . " - Courses" ?></title>
</head>
<body>
    <div id="dashboard">
        <?php include_once("../includes/sheader.php"); ?>

        <div id="main">
            <div id="allcourses" class="content">
                <?php while($course = $courses->fetch_assoc()): ?>
                    <div class="course">
                        <div class="courseCode">
                            <p class="bold"><?= $course['courseCode']; ?></p>
                        </div>
                        <div class="courseName">
                            <p class="bold"><?= $course['courseName']; ?></p>
                            <p><?= $course['deptName']; ?></p>
                        </div>
                        <div class="enrollmentButton">
                            <button value="<?= $course['courseId']; ?>" type="button" class="enrollButton">Enroll</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <script src="../public/js/logout.js"></script>
    <script src="../public/js/dashboard.js"></script>
</body>
</html>