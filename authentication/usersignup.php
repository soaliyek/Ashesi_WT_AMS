<?php
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);

    include("../config/database.php");

    // Get All majors in the database
    $majorsQuery = "SELECT majorName, majorId FROM Majors ORDER BY majorName";
    $majors = $connection->query($majorsQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/signup.css">
    <title>Sign Up</title>
</head>
<body>
    <div id="remarks">
        
    </div>
    <form id="signup">
        <div id="image">

        </div>
        <div id="part1" class="part">
            <div class="form_title">
                <h1>Personal Info</h1>
            </div>
            <div class="form_data">
                <input type="text" name="fname" id="fname" class="entry" placeholder="First Name">
                <input type="text" name="lname" id="lname" class="entry" placeholder="Last Name">
                <div id="roleselection">
                    <select name="role" id="role">
                        <option value="0">Select Your Role</option>
                            <option value="student">Student</option>
                            <option value="faculty">Faculty</option>
                    </select>
                </div>
                <input type="number" name="studentid" id="studentid" class="entry" placeholder="Student ID">
                <div id="majorselection">
                    <select name="major" id="major">
                        <option value="0">Select Your Major</option>
                        <?php while($major = $majors->fetch_assoc()): ?>
                            <option value="<?= $major['majorId']; ?>">
                                <?= $major['majorName']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="additonals">
                <p><a href="usersignin.php">Login Instead</a></p>
                <p>ID format</p>
            </div>
            <div class="button">
                <input type="button" value="Next" onclick="next()">
            </div>
        </div>

        <div id="part2" class="part" style = "display: none">
            <div class="form_title">
                <h1>Account Details</h1>
            </div>
            <div class="form_data">
                <input type="email" name="email" id="email" class="entry" placeholder="Ashesi Email">
                <input type="password" name="password" id="password" class="entry" placeholder="Password">
                <input type="password" name="cpassword" id="cpassword" class="entry" placeholder="Confirm Password">
            </div>
            <div class="additonals">
                <p><a onclick="prev()">Back</a></p>
                <p>Password Match</p>
            </div>
            <div class="button">
                <input type="submit" name="submitBtn" id="submitBtn" value="Register">
            </div>
        </div>
    </form>

    <script src="../public/js/signupvalidation.js"></script>
</body>
</html>