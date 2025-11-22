<?php
    include("../includes/session.php");

    echo "<h2> Welcome " . $_SESSION['old_fname'] . " " . $_SESSION['old_lname'] . "</h2>";
?>