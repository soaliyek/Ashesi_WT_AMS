<?php
session_start();
include_once("../config/database.php");
header("Content-Type: application/json");

function re($status, $message){
    echo json_encode(["status" => $status, "message" => $message]);
    exit();
}

if($_SERVER["REQUEST_METHOD"] != "POST"){
    re("error", "we only accept POST requests!");
}

// Gather the data
$courseId = $_POST["courseId"];
$operation = $_POST["operation"];
$studentId = $_SESSION["studentId"];


// Final Checks
if($courseId === "" || $operation === "" || $studentId === ""){
    re("error", "request Impossible!");
}


// Operation
if($operation === "Enroll"){
    $enroll = $connection->prepare("
        INSERT INTO EnrollRequests (studentId, courseId, status)
        VALUES (?, ?, 'pending')
    ");
    $enroll->bind_param("si", $studentId, $courseId);

    if(!$enroll->execute()){
        re("error", "Could Not Register");
    }
}
else if($operation === "Withdraw"){
    $cancel = $connection->prepare("
        DELETE FROM EnrollRequests 
        WHERE studentId = ? AND courseId = ?
    ");

    $cancel->bind_param("si", $studentId, $courseId);

    if (!$cancel->execute()) {
        re("error", "Could not Cancel");
    }
}else{
    re("error", "Unknown operation.");
}

re("success", "Operation successful.");
exit();

?>