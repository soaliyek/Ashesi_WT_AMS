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

    $studentId = $_SESSION['studentId'];
    $getenrollments = $connection->prepare("
        SELECT 
            c.courseId, 
            c.courseCode, 
            c.courseName, 
            d.deptName
        FROM Enrollments er
        INNER JOIN Courses c ON er.courseId = c.courseId
        INNER JOIN Departments d ON c.deptId = d.deptId
        WHERE er.studentId = ?
    ");
    $getenrollments->bind_param("s", $studentId);
    $getenrollments->execute();
    $enrollments = $getenrollments->get_result();
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
        <?php include_once("../includes/sheader.php"); ?>

        <div id="main">
            <div style="width: 100%; display: flex; justify-content: center; align-items: center;">
                <?php
                if($enrollments->num_rows === 0){
                    echo "<h1><i>No Enrollment Found!</i></h1>";
                }
            ?>
            </div>
            <div id="allmycourses" class="content">
                <?php while($enrollment = $enrollments->fetch_assoc()): ?>
                    <div class="course">
                        <div class="courseCode">
                            <p class="bold"><?= $enrollment['courseCode']; ?></p>
                        </div>
                        <div class="courseName">
                            <p class="bold"><?= $enrollment['courseName']; ?></p>
                            <p><?= $enrollment['deptName']; ?></p>
                        </div>
                        <div class="enrollmentButton">
                            <!--<button value="" type="button" class="enrollButton">Enroll</button> -->
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