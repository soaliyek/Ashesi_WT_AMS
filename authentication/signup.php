<?php

session_start();
require("../config/database.php");

// Only handle POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: usersignup.php");
    exit();
}

// ---------------------------------------
// 1. COLLECT FORM INPUT
// ---------------------------------------
$fname      = trim($_POST["fname"]);
$lname      = trim($_POST["lname"]);
$studentId  = trim($_POST["studentid"]); // VARCHAR primary key
$majorId    = intval($_POST["major"]);   // from dropdown
$email      = trim($_POST["email"]);
$password   = $_POST["password"];
$cpassword  = $_POST["cpassword"];


// Store values in session (to repopulate form in case of error)
$_SESSION["old_fname"] = $fname;
$_SESSION["old_lname"] = $lname;
$_SESSION["old_studentid"] = $studentId;
$_SESSION["old_major"] = $majorId;
$_SESSION["old_email"] = $email;

// ---------------------------------------
// 2. SERVER-SIDE VALIDATION
// ---------------------------------------


// Validate first name (letters only)
if (!preg_match("/^[\p{L} '-]+$/u", $fname)) {
    $_SESSION["error"] = "Invalid first name.";
    header("Location: usersignup.php"); exit();
}

// Validate last name
if (!preg_match("/^[\p{L} '-]+$/u", $lname)) {
    $_SESSION["error"] = "Invalid last name.";
    header("Location: usersignup.php"); exit();
}


// Student ID must be exactly 8 digits
if (!preg_match("/^[0-9]{8}$/", $studentId)) {
    $_SESSION["error"] = "Student ID must be 8 digits.";
    header("Location: usersignup.php"); exit();
}

// Must select a major
if ($majorId <= 0) {
    $_SESSION["error"] = "Please select your major.";
    header("Location: usersignup.php"); exit();
}


// Must be Ashesi email
if (!str_ends_with($email, "@ashesi.edu.gh")) {
    $_SESSION["error"] = "Email must be an Ashesi email.";
    header("Location: usersignup.php"); exit();
}

// Password length
if (strlen($password) < 8) {
    $_SESSION["error"] = "Password must be at least 8 characters.";
    header("Location: usersignup.php"); exit();
}

// Password match
if ($password !== $cpassword) {
    $_SESSION["error"] = "Passwords do not match.";
    header("Location: usersignup.php"); exit();
}

// ---------------------------------------
// 3. CHECK FOR EXISTING EMAIL IN USERS
// ---------------------------------------
$checkEmail = $connection->prepare("
    SELECT userId FROM Users WHERE email = ?
");
$checkEmail->bind_param("s", $email);
$checkEmail->execute();
$emailResult = $checkEmail->get_result();

if ($emailResult->num_rows > 0) {
    $_SESSION["error"] = "Email already exists.";
    header("Location: usersignup.php"); exit();
}

// ---------------------------------------
// 4. CHECK FOR EXISTING STUDENT ID IN STUDENTS
// ---------------------------------------
$checkID = $connection->prepare("
    SELECT studentId FROM Students WHERE studentId = ?
");
$checkID->bind_param("s", $studentId);
$checkID->execute();
$idResult = $checkID->get_result();

if ($idResult->num_rows > 0) {
    $_SESSION["error"] = "Student ID already exists.";
    header("Location: usersignup.php"); exit();
}

// ---------------------------------------
// 5. INSERT INTO USERS TABLE
// ---------------------------------------
$hashed = password_hash($password, PASSWORD_DEFAULT);

$insertUser = $connection->prepare("
    INSERT INTO Users (fName, lName, email, passwordHash, role)
    VALUES (?, ?, ?, ?, 'student')
");
$insertUser->bind_param("ssss", $fname, $lname, $email, $hashed);

if (!$insertUser->execute()) {
    $_SESSION["error"] = "Error creating user.";
    header("Location: usersignup.php"); exit();
}

// Retrieve the userId (AUTO_INCREMENT)
$userId = $connection->insert_id;

// ---------------------------------------
// 6. INSERT INTO STUDENTS TABLE
// ---------------------------------------
$insertStudent = $connection->prepare("
    INSERT INTO Students (studentId, userId, majorId)
    VALUES (?, ?, ?)
");
$insertStudent->bind_param("sii", $studentId, $userId, $majorId);

if (!$insertStudent->execute()) {
    $_SESSION["error"] = "Error creating student profile.";
    header("Location: usersignup.php"); exit();
}

// ---------------------------------------
// 7. SUCCESS — REDIRECT TO LOGIN
// ---------------------------------------
$_SESSION["success"] = "Account created successfully. Please log in.";
header("Location: usersignin.php");
exit();

?>
