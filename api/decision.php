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
$requestId = $_POST["requestId"];
$operation = $_POST["operation"];


// Final Checks
if($requestId === "" || $operation === ""){
    re("error", "request Impossible!");
}


// Operation

// Get the Request
$getRequest = $connection->prepare("
        SELECT studentId, courseId FROM EnrollRequests WHERE requestId = ?
    ");
$getRequest->bind_param("i", $requestId);
$getRequest->execute();
$result = $getRequest->get_result();

$studentId = "";
$courseId = 0;

if($result->num_rows > 0){
    $result = $result->fetch_assoc();
    $studentId = $result["studentId"];
    $courseId = $result["courseId"];
}else{
    re("error", "Request Does not exist");
}

// Go ahead
if($operation === "A"){
    //re("error", "Arrived Here!");
    $enroll = $connection->prepare("
        INSERT INTO Enrollments (studentId, courseId)
        VALUES (?, ?)
    ");
    $enroll->bind_param("si", $studentId, $courseId);
    //re("error", "Arrived Here tooo!");
    if(!$enroll->execute()){
        re("error", "Could Not Register");
    }

    // Delete it now
    $cancel = $connection->prepare("
        UPDATE EnrollRequests
        SET rstatus = 'Approved' 
        WHERE requestId = ?
    ");

    $cancel->bind_param("i", $requestId);
    $cancel->execute();
}
else if($operation === "D"){
    $cancel = $connection->prepare("
        UPDATE EnrollRequests
        SET rstatus = 'Rejected' 
        WHERE requestId = ?
    ");

    $cancel->bind_param("i", $requestId);

    if (!$cancel->execute()) {
        re("error", "Could not Deny");
    }
}else{
    re("error", "Unknown operation.");
}

re("success", "Operation successful.");
exit();

?>