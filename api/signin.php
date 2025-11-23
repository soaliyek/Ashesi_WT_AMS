<?php
session_start();
require("../config/database.php");

header("Content-Type: application/json");

// Only accept POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}


// ======================| COLLECT INPUT
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";


// ======================| VALIDATION
if ($email === "" || $password === "") {
    echo json_encode(["status" => "error", "message" => "Please fill all fields."]);
    exit();
}

if (!str_ends_with($email, "@ashesi.edu.gh")) {
    echo json_encode(["status" => "error", "message" => "Invalid Ashesi email."]);
    exit();
}



// ======================| FIND USER
$query = $connection->prepare("
    SELECT userId, fName, lName, email, passwordHash, role
    FROM Users
    WHERE email = ?
");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "No account matches this email."]);
    exit();
}

$user = $result->fetch_assoc();


// ======================| VERIFY PASSWORD
if (!password_verify($password, $user["passwordHash"])) {
    echo json_encode(["status" => "error", "message" => "Incorrect password."]);
    exit();
}


// ======================| LOGIN SUCCESS: CREATE SESSION
$_SESSION["auth"] = true;
$_SESSION["userId"] = $user["userId"];
$_SESSION["fName"] = $user["fName"];
$_SESSION["lName"] = $user["lName"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];


// ======================| SEND JSON RESPONSE
echo json_encode([
    "status" => "success",
    "message" => "Login successful!",
    "role" => $user["role"]
]);
exit();
?>