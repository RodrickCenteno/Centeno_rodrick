<?php
// Include database connection
include('dbConnect.php');

if (!$con) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Include database connection
if (isset($_POST['submit'])) {
    $studentid = $_POST['studentid'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $contactnumber = $_POST['contactnumber'];
    $course = $_POST['course'];

    // Insert query to add new student data
    $insertNewUser = mysqli_query($con, "INSERT INTO users (studentid, name, age, address, contactnumber, course) VALUES('$studentid', '$name', '$age', '$address', '$contactnumber', '$course')");

    if ($insertNewUser) {
        echo "New record created successfully";
    } else {
        echo "Error: " . mysqli_error($con);
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
    <h2>CREATE OPERATION</h2>
    <form action="index.php" method="POST">
        <label for="studentid">Student ID:</label>
        <input type="text" id="studentid" name="studentid" required><br><br>
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="contactnumber">Contact Number:</label>
        <input type="number" id="contactnumber" name="contactnumber" required><br><br>

        <label for="course">Course:</label>
        <input type="text" id="course" name="course" required><br><br>

        <input type="submit" name="submit" value="Submit">
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
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch records from the database
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
                          </tr>";
                }
            } else {
                echo "<tr>
                        <td colspan='6'>No Records Found</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
