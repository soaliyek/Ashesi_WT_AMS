<?php
session_start();

if (isset($_SESSION["auth"]) && $_SESSION["auth"] === true) {
    
    // Redirect based on role
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

require("../config/database.php");

// Only handle POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: usersignin.php");
    exit();
}

// ---------------------------------------
// 1. COLLECT FORM INPUT
// ---------------------------------------
$email = trim($_POST["email"]);
$password = $_POST["password"];

// Store email temporarily to refill form on error
$_SESSION["old_email"] = $email;


// ---------------------------------------
// 2. VALIDATION
// ---------------------------------------
if (empty($email) || empty($password)) {
    $_SESSION["error"] = "Please fill all fields.";
    header("Location: usersignin.php"); exit();
}

if (!str_ends_with($email, "@ashesi.edu.gh")) {
    $_SESSION["error"] = "Invalid Ashesi email.";
    header("Location: usersignin.php"); exit();
}


// ---------------------------------------
// 3. FETCH USER BY EMAIL
// ---------------------------------------
$findUser = $connection->prepare("
    SELECT userId, fName, lName, email, passwordHash, role
    FROM Users
    WHERE email = ?
");
$findUser->bind_param("s", $email);
$findUser->execute();
$userResult = $findUser->get_result();

if ($userResult->num_rows === 0) {
    $_SESSION["error"] = "No account found with this email.";
    header("Location: usersignin.php"); exit();
}

$user = $userResult->fetch_assoc();


// ---------------------------------------
// 4. VERIFY PASSWORD
// ---------------------------------------
if (!password_verify($password, $user["passwordHash"])) {
    $_SESSION["error"] = "Incorrect password.";
    header("Location: usersignin.php"); exit();
}


// ---------------------------------------
// 5. SUCCESS — CREATE LOGIN SESSION
// ---------------------------------------
$_SESSION["auth"] = true;
$_SESSION["userId"] = $user["userId"];
$_SESSION["fName"] = $user["fName"];
$_SESSION["lName"] = $user["lName"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];


// ---------------------------------------
// 6. REDIRECT BASED ON ROLE
// ---------------------------------------
switch ($user["role"]) {
    case "student":
        header("Location: ../student/dashboard.php");
        break;

    case "faculty":
        header("Location: ../faculty/dashboard.php");
        break;

    case "admin":
        header("Location: ../admin/dashboard.php");
        break;

    default:
        // fallback for unexpected issues
        $_SESSION["error"] = "Invalid user role.";
        header("Location: usersignin.php");
}

exit();
?>
