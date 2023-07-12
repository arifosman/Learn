<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <div class="container-sm">
    <p class="fs-1 fw-bold">ATTENDANCE REPORT</p>
	
    <ul class="nav nav-tabs nav-fill mb-5">
    
        <li class="nav-item">
            <a class="nav-link" href="index.php">Attendance System</a>
        </li>

        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="attendance_report.php">Attendance Report</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="add_student.php">Add Student</a>
        </li>

    </ul>

    <?php
    // Set the timezone to Malaysia
    date_default_timezone_set('Asia/Kuala_Lumpur');

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

    // Update attendance status if the form is submitted
    if (isset($_POST['submit'])) {
        $attendanceId = $_POST['attendance_id'];
        $attendanceStatus = $_POST['attendance_status'];

        // Update attendance status in the database
        $updateAttendanceQuery = "UPDATE attendance SET attendance_status = ? WHERE id = ?";
        $stmtUpdateAttendance = $conn->prepare($updateAttendanceQuery);

        if ($stmtUpdateAttendance) {
            $stmtUpdateAttendance->bind_param("ii", $attendanceStatus, $attendanceId);
            $stmtUpdateAttendance->execute();
            $stmtUpdateAttendance->close();
        } else {
            echo "Error preparing update query: " . $conn->error;
        }
    }

    // Fetch attendance data from the database
    $attendanceQuery = "SELECT a.id, s.student_id, s.student_name, s.class_name, a.attendance_status, a.timestamp 
                        FROM attendance a 
                        INNER JOIN students s ON a.student_id = s.student_id 
                        ORDER BY a.timestamp DESC";
    $result = $conn->query($attendanceQuery);

    if ($result === FALSE) {
        echo "Error executing query: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        echo '
        <div class="table-responsive">
        <table class="table">
                <tr>
                    <th>Attendance ID</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Attendance Status</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                    <th>Save</th>
                </tr>';

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["student_id"] . "</td>";
    echo "<td>" . $row["student_name"] . "</td>";
    echo "<td>" . $row["class_name"] . "</td>";
    echo "<td>" . ($row["attendance_status"] == 1 ? "Present" : "Absent") . "</td>";
    echo "<td>" . date("Y-m-d H:i:s", strtotime($row["timestamp"])) . "</td>";
    echo "<td>";
    echo '<form method="post" action="">';
    echo '<input type="hidden" name="attendance_id" value="' . $row["id"] . '">';
    echo '<select name="attendance_status">';
    echo '<option value="1"' . ($row["attendance_status"] == 1 ? " selected" : "") . '>Present</option>';
    echo '<option value="0"' . ($row["attendance_status"] == 0 ? " selected" : "") . '>Absent</option>';
    echo '</select>';
    echo "</td>";
    echo "<td>"; 
    echo '<div class="text-center">
    <button class="btn btn-primary" input type="submit" name="submit" value="Update">Update</button></div>';
    echo '</form>';
    echo "</td>";
    echo "</tr>";
}


        echo '</div></table>';
         // Generate CSV file for download
        $csvFileName = 'attendance_report.csv';
        $fp = fopen($csvFileName, 'w');
        if ($fp) {
            $headerRow = array('Student ID', 'Student Name', 'Class', 'Attendance Status', 'Timestamp');
            fputcsv($fp, $headerRow);

            // Fetch attendance data again to write to CSV
            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                $dataRow = array(
                    $row["student_id"],
                    $row["student_name"],
                    $row["class_name"],
                    ($row["attendance_status"] == 1 ? "Present" : "Absent"),
                    date("Y-m-d H:i:s", strtotime($row["timestamp"]))
                );
                fputcsv($fp, $dataRow);
            }

            fclose($fp);

            // Provide download link
            echo '<p><a href="' . $csvFileName . '" class="btn btn-primary" tabindex="-1" role="button" download>Download Attendance Report (CSV)</a></p>';
        } else {
            echo "Error creating CSV file.";
        }
    } else {
        echo "<p>No attendance records found.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
    </div>
    
</body>
</html>
