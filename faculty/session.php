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
        <?php include_once("../includes/fheader.php"); ?>
        <div id="main">
            <h2 id="createSessionTitle">Create Attendence Session</h2>
            <p id="return"></p>
            <form id="createSession">
                <div id="departmentSelection">
                    <select name="courseId" id="courseSelect">
                        <option value="0">Select Course</option>
                        <?php while($course = $courses->fetch_assoc()): ?>
                            <option value="<?= $course['courseId']; ?>">
                                <?= $course['courseName']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <input type="text" name="sessionPIN" class="entry" id="" placeholder="Session PIN">
                <input type="submit" id="button" value="CREATE">
            </form>
        </div>
    </div>
    <script src="../public/js/logout.js"></script>
    <script>
        const createAttendanceSession = document.getElementById("createSession");
        createAttendanceSession.addEventListener("submit", function(e){
            e.preventDefault();

            const request = new XMLHttpRequest();
            const data =  new FormData(e.target);

            request.open("POST", "../api/createSession.php", true);
            //request.setRequestHeader("Content-Type", "application/json");
            //alert("Hi");

            request.onreadystatechange = function(){
                if(request.readyState === XMLHttpRequest.DONE && request.status === 200){
                    // Process the reponse
                    const response = JSON.parse(request.responseText);
                    //console.log("Successful: ", request.responseText);
                    //console.log("Response:", request.responseText);
                    //console.log("Response:", response);

                    // In your AJAX success:
                    
                    if (response.status === "success") {
                        e.target.reset();
                        const ret = document.getElementById("return");
                        ret.innerHTML = response.message;
                    }
                    const ret = document.getElementById("return");
                    ret.innerHTML = response.message;
                    

                }else if(request.readyState === XMLHttpRequest.DONE && request.status !== 200){
                    console.log("Error:", request.status, request.statusText);
                }
            }

            request.send(data);
        });

    </script>
    <!-- <script src="../public/js/adminops.js"></script> -->
</body>
</html>