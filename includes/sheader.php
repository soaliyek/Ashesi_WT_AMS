<header>
    <nav>
        <a href="mycourses.php" id="mycourses">
            <p>My Cources</p>
        </a>
        <a href="courses.php" id="courses">
            <p>Courses</p>
        </a>
        <a href="enrollments.php" id="enrollments">
            <p>Enrollments</p>
        </a>
    </nav>
    <div id="profile">
        <div id="picture">
            <img src="../public/images/profile.png" alt="" srcset="">
        </div>
        <div id="text">
            <p class="bold"> <?php echo $_SESSION['role'] ?></p>
            <p><?php echo $_SESSION['fName'] . " " . $_SESSION['lName']  ?></p>
        </div>
    </div>
    <div id="siguout">
        <button type="button" onclick="logout()">Logout</button>
    </div>
</header>