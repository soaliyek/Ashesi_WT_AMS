<?php
    include_once("../includes/nosession.php");

    echo "<h2>" . $_SESSION['fName'] . " " . $_SESSION['lName'] . ": Welcome to " . $_SESSION['role'] . " Dashboard!</h2>";
?>