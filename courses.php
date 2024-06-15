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
    $description = $_POST['description'];
    $sql = "INSERT INTO courses (name, description) VALUES ('$name', '$description')";
    $conn->query($sql);
}

// Read
$result = $conn->query("SELECT * FROM courses");

// Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $sql = "UPDATE courses SET name='$name', description='$description' WHERE id=$id";
    $conn->query($sql);
}

// Delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM courses WHERE id=$id";
    $conn->query($sql);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this record?');
        }

        function editCourse(id, name, description) {
            document.getElementById('id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('description').value = description;
        }
    </script>
</head>
<body>
    <div class="coursescontainer">
        <h1>Manage Courses</h1>
        <form method="post">
            <input type="hidden" name="id" id="id">
            <label>Name: </label><input type="text" name="name" id="name" required><br>
            <label>Description: </label><textarea name="description" id="description" required></textarea><br>
            <button type="submit" name="create" class="button">Create</button>
            <button type="submit" name="update" class="button">Update</button>
        </form>
        <h2>Course List</h2>
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>
                    <button onclick="editCourse(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', '<?php echo $row['description']; ?>')">Edit</button>
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
