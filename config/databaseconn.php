<?php

# server name/IP
$servername = "localhost";

# User
$username = "root";

# Pass if any
$password = "";

# Database name
$databasename = "ashesiwtattendancemanagement";

$port = 3307;

# Create a connection
$conn = new mysqli($servername, $username, $password, $databasename, $port);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected Successfully!";

#$conn->close();

?>