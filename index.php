<?php

include('dbConnect.php');

if (!$con) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}


$studentid = $name = $age = $address = $contactnumber = $course = "";
$update = false;

// Insert new record
if (isset($_POST['submit'])) {
    $studentid = $_POST['studentid'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $contactnumber = $_POST['contactnumber'];
    $course = $_POST['course'];

    // Check if the student ID already exists
    $checkQuery = mysqli_query($con, "SELECT * FROM users WHERE studentid = '$studentid'");
    if (mysqli_num_rows($checkQuery) > 0) {
        echo "Error: Student ID '$studentid' already exists.";
    } else {
        // Insert query to add new student data
        $insertNewUser = mysqli_query($con, "INSERT INTO users (studentid, name, age, address, contactnumber, course) VALUES('$studentid', '$name', '$age', '$address', '$contactnumber', '$course')");
        if ($insertNewUser) {
            echo "New record created successfully";
            // Clear form fields after submission
            $studentid = $name = $age = $address = $contactnumber = $course = "";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}

// Update existing record
if (isset($_POST['update'])) {
    $studentid = $_POST['studentid'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $contactnumber = $_POST['contactnumber'];
    $course = $_POST['course'];

    $updateQuery = mysqli_query($con, "UPDATE users SET name='$name', age='$age', address='$address', contactnumber='$contactnumber', course='$course' WHERE studentid='$studentid'");
    if ($updateQuery) {
        echo "Record updated successfully";
        // Clear form fields after update
        $studentid = $name = $age = $address = $contactnumber = $course = "";
        $update = false;
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}

// Delete record
if (isset($_GET['delete'])) {
    $studentid = $_GET['delete'];
    $deleteQuery = mysqli_query($con, "DELETE FROM users WHERE studentid='$studentid'");
    if ($deleteQuery) {
        echo "Record deleted successfully";
        // Clear form fields after deletion
        $studentid = $name = $age = $address = $contactnumber = $course = "";
        $update = false;
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

// Fetch record for editing
if (isset($_GET['edit'])) {
    $studentid = $_GET['edit'];
    $result = mysqli_query($con, "SELECT * FROM users WHERE studentid='$studentid'");
    if ($result) {
        $row = mysqli_fetch_array($result);
        $studentid = $row['studentid'];
        $name = $row['name'];
        $age = $row['age'];
        $address = $row['address'];
        $contactnumber = $row['contactnumber'];
        $course = $row['course'];
        $update = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENTS DATA</title>
</head>
<body>
    <h1>STUDENTS DATA</h1>
    <h2>CREATE/UPDATE/ DELETE OPERATION</h2>
    
    <form action="index.php" method="POST">
        <label for="studentid">Student ID:</label>
        <input type="text" id="studentid" name="studentid" required value="<?php echo $studentid; ?>"><br><br>
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required value="<?php echo $name; ?>"><br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required value="<?php echo $age; ?>"><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required value="<?php echo $address; ?>"><br><br>

        <label for="contactnumber">Contact Number:</label>
        <input type="text" id="contactnumber" name="contactnumber" required value="<?php echo $contactnumber; ?>"><br><br>

        <label for="course">Course:</label>
        <input type="text" id="course" name="course" required value="<?php echo $course; ?>"><br><br>

        
        <?php if ($update): ?>
            <input type="submit" name="update" value="Update">
        <?php else: ?>
            <input type="submit" name="submit" value="Submit">
        <?php endif; ?>
    </form>
    <hr>

    <h2>Read Operation</h2>

    <table border="1">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // GET records from the database
            $result = mysqli_query($con, "SELECT * FROM users");

            if (mysqli_num_rows($result) != 0) {
                while ($users = mysqli_fetch_array($result)) {
                    echo "<tr>
                            <td>".$users['studentid']."</td>
                            <td>".$users['name']."</td>
                            <td>".$users['age']."</td>
                            <td>".$users['address']."</td>
                            <td>".$users['contactnumber']."</td>
                            <td>".$users['course']."</td>
                            <td>
                                <a href='index.php?edit=".$users['studentid']."'>Edit</a> |
                                <a href='index.php?delete=".$users['studentid']."' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No Records Found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
