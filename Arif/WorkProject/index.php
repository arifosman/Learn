<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "attendance_db";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process attendance submission
if (isset($_POST['attendance_submit'])) {
    $attendance = $_POST['attendance'];

    // Get the current date and time
    $timestamp = date('Y-m-d H:i:s');

    foreach ($attendance as $studentId => $status) {
        // Insert attendance data into the database
        $insertQuery = "INSERT INTO attendance (student_id, attendance_status, timestamp) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("iss", $studentId, $status, $timestamp);
        $stmt->execute();
    }

    // Redirect back to the index.php page
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../WorkProject/LENCANA_TERBAHARU-removebg-preview.png">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <div class="container-sm">
    <p class="fs-1 fw-bold">ATTENDANCE SYSTEM</p>
    
    <ul class="nav nav-tabs nav-fill mb-5">
        
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Attendance System</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="attendance_report.php">Attendance Report</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="add_student.php">Add Student</a>
        </li>

    </ul>
    
    <form method="post" action="index.php">
    <div class="container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>Attended</th>
                <th>Unattended</th>
            </tr>
        </thead>
            <?php
            // Fetch student details from the database
            $studentsQuery = "SELECT * FROM students";
            $result = $conn->query($studentsQuery);

            if ($result === FALSE) {
                echo "Error executing query: " . $conn->error;
            } elseif ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["student_id"] . "</td>";
                    echo "<td>" . $row["student_name"] . "</td>";
                    echo "<td>" . $row["class_name"] . "</td>";
                    echo "<td>";
                    echo "<input type='radio' name='attendance[" . $row["student_id"] . "]' value='1'> Present";
                    echo "</td>";
                    echo "<td>";
                    echo "<input type='radio' name='attendance[" . $row["student_id"] . "]' value='0'> Absent";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No students found. Please add students.</td></tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </table>

    </div>    
    
        <br>
        <div class="d-grid gap-2 col-1 mx-auto">
            <button class="btn btn-primary" input type="submit" name="attendance_submit" value="Submit">Submit</button>
        </div>
        
    </form>
   </div>

</body>
</html>
