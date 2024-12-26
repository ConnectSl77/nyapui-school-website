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

// Fetch application details based on the source
if ($source === 'sss') {
    $stmt = $conn->prepare("SELECT * FROM sss_applications WHERE id = ?");
} elseif ($source === 'jss') {
    $stmt = $conn->prepare("SELECT * FROM jss_applications WHERE id = ?");
}
$stmt->bind_param("i", $app_id);
$stmt->execute();
$result = $stmt->get_result();
$application = $result->fetch_assoc();

// Close the statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit Application</h2>
        <form method="POST" action="update_application.php">
            <input type="hidden" name="id" value="<?php echo $application['id']; ?>">
            <input type="hidden" name="source" value="<?php echo $source; ?>">
            <div class="form-group">
                <label for="pupilName">Name of Pupil:</label>
                <input type="text" class="form-control" id="pupilName" name="name" value="<?php echo htmlspecialchars($application['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($application['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($application['dob']); ?>" required>
            </div>
            <!-- Add other fields as necessary -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <a href="applications_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 