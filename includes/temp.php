
<!-- Session Expiry checks -->
<?php

//
// by Default, the SESSION gets destroyed in 24 minutes
// This code is to modify this and bring it's life time to say, 30 minutes
//

session_start();

$timeout = 1800; // 30 minutes

if (isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"] > $timeout)) {
    // Session expired
    session_unset();
    session_destroy();
    header("Location: ../auth/usersignin.php?expired=true");
    exit();
}

?>

<?php while($course = $courses->fetch_assoc()): ?>
                    <option value="<?= $course['majorId']; ?>">
                        <?= $major['majorName']; ?>
                    </option>
                <?php endwhile; ?>