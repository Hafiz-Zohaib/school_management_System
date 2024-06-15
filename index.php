<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>School Management System</h1>
        <ul>
            <li><a href="students.php">Students</a></li>
            <li><a href="teachers.php">Teachers</a></li>
            <li><a href="courses.php">Courses</a></li>
            <li><a href="classes.php">Classes</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>
