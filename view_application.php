<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Include database connection
$conn = new mysqli('localhost', 'root', 'mysql', 'admin_dashboard');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the application ID from the query parameter
$app_id = $_GET['id'];

// Fetch application details for SSS
$stmt = $conn->prepare("SELECT * FROM sss_applications WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $app_id);
$stmt->execute();
$result = $stmt->get_result();
$sss_application = $result->fetch_assoc();

// If not found in SSS, check JSS
if (!$sss_application) {
    $stmt = $conn->prepare("SELECT * FROM jss_applications WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $app_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $jss_application = $result->fetch_assoc();
}

// Close the statement
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Application Details</h2>
        <div class="card">
            <div class="card-body">
                <?php if ($sss_application): ?>
                    <h5>SSS Application</h5>
                    <p><strong>ID:</strong> <?php echo htmlspecialchars($sss_application['id']); ?></p>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($sss_application['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($sss_application['email']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($sss_application['status']); ?></p>
                    <!-- Add more fields as necessary -->
                <?php elseif ($jss_application): ?>
                    <h5>JSS Application</h5>
                    <p><strong>ID:</strong> <?php echo htmlspecialchars($jss_application['id']); ?></p>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($jss_application['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($jss_application['email']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($jss_application['status']); ?></p>
                    <!-- Add more fields as necessary -->
                <?php else: ?>
                    <p class="text-danger">Application not found.</p>
                <?php endif; ?>
                <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 