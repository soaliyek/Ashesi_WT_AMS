<?php
    include_once("../includes/nosession.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['fName'] . " " . $_SESSION['lName'] . " - Dashboard" ?></title>
</head>
<body>
    <?php echo "<h2>" . $_SESSION['fName'] . " " . $_SESSION['lName'] . ": Welcome to " . $_SESSION['role'] . " Dashboard!</h2>"; ?>
</body>
</html>