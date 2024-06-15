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
    $course_id = $_POST['course_id'];
    $teacher_id = $_POST['teacher_id'];
    $sql = "INSERT INTO classes (name, course_id, teacher_id) VALUES ('$name', '$course_id', '$teacher_id')";
    $conn->query($sql);
}

// Read
$result = $conn->query("SELECT classes.*, courses.name as course_name, teachers.name as teacher_name 
                        FROM classes 
                        JOIN courses ON classes.course_id = courses.id 
                        JOIN teachers ON classes.teacher_id = teachers.id");

// Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $course_id = $_POST['course_id'];
    $teacher_id = $_POST['teacher_id'];
    $sql = "UPDATE classes SET name='$name', course_id='$course_id', teacher_id='$teacher_id' WHERE id=$id";
    $conn->query($sql);
}

// Delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM classes WHERE id=$id";
    $conn->query($sql);
}

$courses = $conn->query("SELECT * FROM courses");
$teachers = $conn->query("SELECT * FROM teachers");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Classes</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this record?');
        }

        function editClass(id, name, course_id, teacher_id) {
            document.getElementById('id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('course_id').value = course_id;
            document.getElementById('teacher_id').value = teacher_id;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Manage Classes</h1>
        <form method="post">
            <input type="hidden" name="id" id="id">
            <label>Name: </label><input type="text" name="name" id="name" required><br>
            <label>Course: </label>
            <select name="course_id" id="course_id" required>
                <?php while ($course = $courses->fetch_assoc()) { ?>
                <option value="<?php echo $course['id']; ?>"><?php echo $course['name']; ?></option>
                <?php } ?>
            </select><br><br>
            <label>Teacher: </label>
            <select name="teacher_id" id="teacher_id" required>
                <?php while ($teacher = $teachers->fetch_assoc()) { ?>
                <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['name']; ?></option>
                <?php } ?>
            </select><br><br>
            <button type="submit" name="create" class="button">Create</button>
            <button type="submit" name="update" class="button">Update</button>
        </form>
        <h2>Class List</h2>
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Course</th>
                <th>Teacher</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['Name']; ?></td>
                <td><?php echo $row['course_name']; ?></td>
                <td><?php echo $row['teacher_name']; ?></td>
                <td>
                    <button onclick="editClass(<?php echo $row['id']; ?>, '<?php echo $row['Name']; ?>', '<?php echo $row['course_id']; ?>', '<?php echo $row['teacher_id']; ?>')">Edit</button>
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
