<?php
session_start();
require("../config/database.php");

// JSON output
header('Content-Type: application/json');

// Helper function
function respond($status, $message) {
    echo json_encode(["status" => $status, "message" => $message]);
    exit();
}

// Must be POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    respond("error", "Invalid request method.");
}

// Collect form input
$courseId   = trim($_POST["courseId"] ?? "");
$sessionPIN = trim($_POST["sessionPIN"] ?? "");
$facultyId  = $_SESSION["facultyId"] ?? "";

// ======================| VALIDATION
if ($courseId === "0" || $sessionPIN === "" || $facultyId === "") {
    respond("error", "All fields are required.");
}

// Course ID must be a number
if (!ctype_digit($courseId)) {
    respond("error", "Invalid course ID.");
}

// PIN must be exactly 4 digits
if (!preg_match("/^[0-9]{4}$/", $sessionPIN)) {
    respond("error", "PIN must be exactly 4 digits.");
}

// ======================| CREATE SESSION VALUES
$sessionDate = date("Y-m-d");                     
$startTime   = date("Y-m-d H:i:s");               
$endTime     = date("Y-m-d H:i:s", time() + 420); //7 minutes

$isPublished = 1;

// ======================| INSERT INTO DATABASE
$query = $connection->prepare("
    INSERT INTO AttendanceSessions 
    (courseId, facultyId, sessionDate, startTime, endTime, topic, isPublished)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$query->bind_param(
    "iissssi",
    $courseId,
    $facultyId,
    $sessionDate,
    $startTime,
    $endTime,
    $sessionPIN,
    $isPublished
);

if (!$query->execute()) {
    respond("error", "Database error: " . $query->error);
}

// ======================| SUCCESS
respond("success", "Attendance session created successfully!");
?>
