<?php
    // Create Database Connection Infomation
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "ashesiwtattendancemanagement";
    $port = 3307;

    // Create a connection
    $connection = new mysqli($server, $user, $password, $database, $port);

    // Check if connection established
    if($connection->connect_error){
        die("Connection Failed " . $connection->connect_error);
    }

    // Message
    //echo "Connected Successfully to the Database!\n";
?>