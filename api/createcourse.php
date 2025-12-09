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

// Course Info
$courseCode      = trim($_POST["courseCode"] ?? "");
$courseName      = trim($_POST["courseName"] ?? "");
$departmentId       = trim($_POST["department"] ?? "0");


// ======================| VALIDATION
if($courseCode === "" || $courseName === "" || $departmentId === "0"){
    re("error", "You must fill all fields");
}

// ======================| CHECK COURSE
$check = $connection->prepare("SELECT courseId FROM Courses WHERE courseCode=?");
$check->bind_param("s", $courseCode);
$check->execute();
$result = $check->get_result();
if ($result->num_rows > 0) respond("error", "Email already exists.");


// ======================| INSERT INTO COURSES
$insertCourse = $connection->prepare("
    INSERT INTO Courses (deptId, courseCode, courseName)
    VALUES (?, ?, ?)
");
$insertCourse->bind_param("iss", $departmentId, $courseCode, $courseName);

if (!$insertCourse->execute()) {
    respond("error", "Failed to create course.");
}

// ======================| UP TO THIS LINE = SUCCESS
respond("success", "Course created successfully!");
?>