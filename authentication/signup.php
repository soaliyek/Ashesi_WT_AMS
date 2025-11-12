<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/authentication.css">
    <title>Sign up</title>
</head>
<body>
    <div id="signup">
        <div id="image">

        </div>
        <form id="functional" action = "register.php" method = "POST">
            <div id="title">
                <h1>Welcome!</h1>
            </div>
            <div id="data">
                <input type="text" name="fname" id="fname" placeholder="First Name" class="entry">
                <input type="text" name="lname" id="lname" placeholder="Last Name" class="entry">
                <input type="email" name="email" id="email" placeholder="Email" class="entry">
                <input type="password" name="password" id="password" placeholder="Password" class="entry">
                <input type="password" name="conf_password" id="conf_password" placeholder="Confirm Password" class="entry">
            </div>
            <div id="change">
                <a href="login.html">Login instead</a>
                <p id="match">Does not match</p>
            </div>
            <div id="button">
                <input type="submit" value="Register" id="login_button">
            </div>
        </form>
    </div>
    <script src="../public/js/formvalidation.js"></script>
</body>
</html>