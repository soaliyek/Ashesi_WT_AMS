<?php
session_start();
require("../config/database.php");

// Specify the return type for js
header('Content-Type: application/json');

// Response
function respond($status, $message) {
    echo json_encode(["status" => $status, "message" => $message]);
    exit();
}

// Consider on POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    respond("error", "Invalid request method.");
}

// Personal Info
$fname      = trim($_POST["fname"] ?? "");
$lname      = trim($_POST["lname"] ?? "");
$role       = trim($_POST["role"] ?? "0");

// If it is student
$studentId  = trim($_POST["studentid"] ?? "");
$majorId    = intval($_POST["major"] ?? 0);

// Account info
$email      = trim($_POST["email"] ?? "");
$password   = $_POST["password"] ?? "";
$cpassword  = $_POST["cpassword"] ?? "";


// ======================| VALIDATION
if (!preg_match("/^[\p{L} '-]+$/u", $fname)) respond("error", "Invalid first name.");
if (!preg_match("/^[\p{L} '-]+$/u", $lname)) respond("error", "Invalid last name.");

if ($role !== "student" && $role !== "faculty") respond("error", "Invalid role selection.");

if ($role === "student") {
    if (!preg_match("/^[0-9]{8}$/", $studentId)) respond("error", "Student ID must be 8 digits.");
    if ($majorId <= 0) respond("error", "Please select your major.");
}

if (!str_ends_with($email, "@ashesi.edu.gh")) respond("error", "Email must be an Ashesi email.");

if (strlen($password) < 8) respond("error", "Password must be at least 8 characters.");
if ($password !== $cpassword) respond("error", "Passwords do not match.");


// ======================| CHECK EMAIL
$check = $connection->prepare("SELECT userId FROM Users WHERE email=?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();
if ($result->num_rows > 0) respond("error", "Email already exists.");


// ======================| FOR STUDENTS: CHECK STUDENT ID
if ($role === "student") {
    $checkId = $connection->prepare("SELECT studentId FROM Students WHERE studentId=?");
    $checkId->bind_param("s", $studentId);
    $checkId->execute();
    $resultId = $checkId->get_result();
    if ($resultId->num_rows > 0) respond("error", "Student ID already taken.");
}


// ======================| INSERT INTO USERS
$hashed = password_hash($password, PASSWORD_DEFAULT);

$insertUser = $connection->prepare("
    INSERT INTO Users (fName, lName, email, passwordHash, role)
    VALUES (?, ?, ?, ?, ?)
");
$insertUser->bind_param("sssss", $fname, $lname, $email, $hashed, $role);

if (!$insertUser->execute()) {
    respond("error", "Failed to create user.");
}

$userId = $connection->insert_id;


// ======================| INSERT INTO STUDENTS OR FACULTY
if ($role === "student") {
    $insertStudent = $connection->prepare("
        INSERT INTO Students (studentId, userId, majorId)
        VALUES (?, ?, ?)
    ");
    $insertStudent->bind_param("sii", $studentId, $userId, $majorId);

    if (!$insertStudent->execute()) respond("error", "Failed to create student profile.");
}

if ($role === "faculty") {
    $insertFaculty = $connection->prepare("
        INSERT INTO Faculty (userId)
        VALUES (?)
    ");
    $insertFaculty->bind_param("i", $userId);

    if (!$insertFaculty->execute()) respond("error", "Failed to create faculty profile.");
}

// ======================| UP TO THIS LINE = SUCCESS
respond("success", "Account created successfully! Redirecting...");
?>