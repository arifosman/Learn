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

// Process attendance form submission
if (isset($_POST['submit'])) {
    if (isset($_POST['attendance'])) {
        $attendance = $_POST['attendance'];

        // Save attendance data to the database
        foreach ($attendance as $studentId => $value) {
            // Prepare and execute the insert query
            $insertQuery = "INSERT INTO attendance (student_id, attendance_status) VALUES (?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ii", $studentId, $value);
            $stmt->execute();
        }
    }
}

// Close the database connection
$conn->close();

// Redirect to the attendance report page
header("Location: attendance_report.php");
exit;
?>
