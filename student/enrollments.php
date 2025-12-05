<?php
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);
    
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

    $getrequests = $connection->prepare("
        SELECT 
            c.courseId, 
            c.courseCode, 
            c.courseName, 
            d.deptName,
            er.rstatus
        FROM Enrollrequests er
        INNER JOIN Courses c ON er.courseId = c.courseId
        INNER JOIN Departments d ON c.deptId = d.deptId
        WHERE er.studentId = ?
    ");
    $getrequests->bind_param("s", $studentId);
    $getrequests->execute();
    $requests = $getrequests->get_result();

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
                    if($requests->num_rows === 0){
                        echo "<h1 ><i>No Request Found!</i></h1>";
                    }
                ?>
            </div>
            <div id="allmyenrolments" class="content">
                <?php while($request = $requests->fetch_assoc()): ?>
                    <div class="course">
                        <div class="courseCode">
                            <p class="bold"><?= $request['courseCode']; ?></p>
                        </div>
                        <div class="courseName">
                            <p class="bold"><?= $request['courseName']; ?></p>
                            <p><?= $request['deptName']; ?></p>
                        </div>
                        <div class="enrollmentButton">
                            <?php
                            $color = $request['rstatus'] === 'Approved' ? 'green' :
                                    ($request['rstatus'] === 'Rejected' ? 'red' : 'orange');
                            ?>
                            <p style="background-color: <?= $color ?>;"><?= htmlspecialchars($request['rstatus']); ?></p>
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