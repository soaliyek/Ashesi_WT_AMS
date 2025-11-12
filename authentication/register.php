<?php

include("../config/databaseconn.php");

//$fname = $_POST["fname"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fname = $_POST['fname'];
}

?>