<?php
session_start();
include 'db_connection.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user information
$user_id = $_SESSION['user_id'];
$query = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch user's applications
$query = "SELECT id, application_data, status, created_at FROM student_applications WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$applications = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Student Dashboard</title>
    <style>
        body { background-color: #f9f9f9; }
        .dashboard-container { max-width: 800px; margin: auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .logo { display: block; margin: 0 auto 20px; width: 100px; }
    </style>
</head>
<body>
    <div class="dashboard-container mt-5">
        <h2 class="text-center">Welcome to Nyapui Senior Secondary School of Excellence Student Portal, <?php echo htmlspecialchars($user['username']); ?>!</h2>
        <div class="text-center mb-4">
            <a href="form.html" class="btn btn-success">Submit New Application</a>
            <a href="application_status.php" class="btn btn-info">Check Application Status</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <h3>Your Applications</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Application Data</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $applications->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['application_data']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
