<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', 'mysql', 'admin_dashboard');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the application ID and source
$app_id = $_GET['id'];
$source = $_GET['source'];

// Update the application status to "Approved"
if ($source === 'sss') {
    $stmt = $conn->prepare("UPDATE sss_applications SET status = 'Approved' WHERE id = ?");
} elseif ($source === 'jss') {
    $stmt = $conn->prepare("UPDATE jss_applications SET status = 'Approved' WHERE id = ?");
}
$stmt->bind_param("i", $app_id);

// Execute the statement
if ($stmt->execute()) {
    header("Location: applications_dashboard.php"); // Redirect back to the dashboard
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?> 