<?php

$findallmajors = "SELECT majorName, majorId FROM Majors ORDER BY majorName";
$findallcourses = "SELECT c.courseId, d.deptId, d.deptName, c.courseCode, c.courseName FROM Courses c INNER JOIN Departments d ON d.deptId = c.deptId ORDER BY deptId";


?>