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

// Fetch all SSS applications
$sss_applications = $conn->query("SELECT * FROM sss_applications ORDER BY created_at DESC");

// Fetch all JSS applications
$jss_applications = $conn->query("SELECT * FROM jss_applications ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Applications Dashboard</h2>

        <h3>SSS Applications</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $sss_applications->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <a href="view_application.php?id=<?php echo $row['id']; ?>&source=sss" class="btn btn-info">View</a>
                            <a href="edit_application.php?id=<?php echo $row['id']; ?>&source=sss" class="btn btn-warning">Edit</a>
                            <a href="approve_application.php?id=<?php echo $row['id']; ?>&source=sss" class="btn btn-success">Approve</a>
                            <a href="delete_application.php?id=<?php echo $row['id']; ?>&source=sss" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>JSS Applications</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $jss_applications->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <a href="view_application.php?id=<?php echo $row['id']; ?>&source=jss" class="btn btn-info">View</a>
                            <a href="edit_application.php?id=<?php echo $row['id']; ?>&source=jss" class="btn btn-warning">Edit</a>
                            <a href="approve_application.php?id=<?php echo $row['id']; ?>&source=jss" class="btn btn-success">Approve</a>
                            <a href="delete_application.php?id=<?php echo $row['id']; ?>&source=jss" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 