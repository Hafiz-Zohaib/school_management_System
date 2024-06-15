<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';

// Create
if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $sql = "INSERT INTO students (name, email, phone, address) VALUES ('$name', '$email', '$phone', '$address')";
    $conn->query($sql);
}

// Read
$result = $conn->query("SELECT * FROM students");

// Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $sql = "UPDATE students SET name='$name', email='$email', phone='$phone', address='$address' WHERE id=$id";
    $conn->query($sql);
}

// Delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM students WHERE id=$id";
    $conn->query($sql);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Students</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this record?');
        }

        function editStudent(id, name, email, phone, address) {
            document.getElementById('id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('email').value = email;
            document.getElementById('phone').value = phone;
            document.getElementById('address').value = address;
        }
    </script>
</head>
<body>
    <div class="studentcontainer">
        <h1>Manage Students</h1>
        <form method="post">
            <input type="hidden" name="id" id="id">
            <label>Name: </label><input type="text" name="name" id="name" required><br>
            <label>Phone: </label><input type="text" name="phone" id="phone"><br>
            <label>Address: </label><input type="text" name="address" id="address"><br>
            <label>Email: </label><input type="email" name="email" id="email" required><br>
            <button type="submit" name="create" class="button">Create</button> 
            <button type="submit" name="update" class="button">Update</button>
             
        </form>
        
        <h2>Student List</h2>
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td>
                    <button onclick="editStudent(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', '<?php echo $row['email']; ?>', '<?php echo $row['phone']; ?>', '<?php echo $row['address']; ?>')">Edit</button>
                    
                    <form method="post" style="display:inline;" onsubmit="return confirmDelete();">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            
            <?php } ?>
        </table>
            
    </div>
</body>
</html>
