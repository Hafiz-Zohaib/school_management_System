<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $result = $conn->query("SELECT * FROM admins WHERE username='$username'");
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            header('Location: index.php');
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Invalid username!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <label>Username: </label><input type="text" name="username" required> <br>
            <label>Password: </label><input type="password" name="password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
