<?php
    include("config/databaseconn.php");

    $query = "SELECT first_name, email FROM users";

    $query_result = $conn->query($query);

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
</head>
<body>
    <?php
        $name = "Soaliye Albert";
        echo "Hey There!</br>";
        echo "My name is $name";

        echo "<h4> $query_result->num_rows Records found!</h4>";

        while($email = $query_result->fetch_assoc()){
            echo "{$email['email']}";
        }
    ?>
</body>
</html>