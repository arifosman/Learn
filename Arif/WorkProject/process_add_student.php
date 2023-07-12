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

if (isset($_POST['submit'])) {
    $studentName = $_POST['student_name'];
    $className = $_POST['class_name'];

    // Insert new student into the database
    $insertStudentQuery = "INSERT INTO students (student_name, class_name) VALUES (?, ?)";
    $stmtStudent = $conn->prepare($insertStudentQuery);

    if ($stmtStudent) {
        $stmtStudent->bind_param("ss", $studentName, $className);
        $stmtStudent->execute();

        // Redirect back to the index.php page
        header("Location: index.php");
        exit;
    } else {
        echo "Error preparing student query: " . $conn->error;
    }

    // Close the prepared statement
    $stmtStudent->close();
}

// Close the database connection
$conn->close();
?>
