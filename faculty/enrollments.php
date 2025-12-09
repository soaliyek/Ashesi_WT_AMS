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

    $getrequests = $connection->prepare("
        SELECT 
            c.courseCode, 
            c.courseName,
            u.fName,
            u.lName,
            s.studentId,
            er.requestId,
            d.deptName
        FROM EnrollRequests er
        INNER JOIN Courses c ON er.courseId = c.courseId
        INNER JOIN Departments d ON c.deptId = d.deptId
        INNER JOIN Students s ON er.studentId = s.studentId
        INNER JOIN Users u ON s.userId = u.userId
        WHERE er.rstatus = 'Pending'
    ");
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
        <?php include_once("../includes/fheader.php"); ?>
        <div id="main">
            <div id="enrollments" class="content">
                <?php while($request = $requests->fetch_assoc()): ?>
                    <div class="course">
                        <div class="courseCode">
                            <p class="bold"><?= $request['courseCode']; ?></p>
                        </div>
                        <div class="courseName">
                            <p class="bold"><?= $request['courseName']; ?></p>
                            <p><?= $request['deptName']; ?></p>
                            <p class="bold"><?= $request['fName']; ?> <?= $request['lName']; ?></p>
                        </div>
                        <div class="decision">
                            <button id="den" value="<?php echo $request['requestId'] ?>" type="button" class="decButton">D</button>
                            <button id="acc" value="<?php echo $request['requestId'] ?>" type="button" class="decButton">A</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <script src="../public/js/logout.js"></script>
    <script src="../public/js/adminops.js"></script>
</body>
</html>