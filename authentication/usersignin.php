<?php

    include("../config/database.php");

    // Get All majors in the database
    $majorsQuery = "SELECT majorName FROM majors ORDER BY majorName";
    $majors = $connection->query($majorsQuery);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/signup.css">
    <title>Sign In</title>
</head>
<body>
    <div id="remarks">

    </div>
    <form id="signin">

        <div id="part2" class="part">
            <div class="form_title">
                <h1>Welcome Back</h1>
            </div>
            <div class="form_data">
                <input type="email" name="email" id="email" class="entry" placeholder="Ashesi Email">
                <input type="password" name="password" id="password" class="entry" placeholder="Password">
            </div>
            <div class="additonals">
                <p><a href="usersignup.php">Register Instead</a></p>
                <p><a href="">Forgot Password?</a></p>
            </div>
            <div class="button">
                <input type="submit" name="submitBtn" id="submitBtn" value="Sign In">
            </div>
        </div>

        <div id="image">

        </div>
    </form>

    <script src="../public/js/signinvalidation.js"></script>
</body>
</html>