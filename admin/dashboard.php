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

// Fetch application statistics
$total_students = $conn->query("SELECT COUNT(*) FROM applications")->fetch_row()[0];
$total_jss_students = $conn->query("SELECT COUNT(*) FROM jss_applications")->fetch_row()[0];
$pending_applications = $conn->query("SELECT COUNT(*) FROM applications WHERE status = 'pending'")->fetch_row()[0];
$pending_jss_applications = $conn->query("SELECT COUNT(*) FROM jss_applications WHERE status = 'pending'")->fetch_row()[0];
$approved_applications = $conn->query("SELECT COUNT(*) FROM applications WHERE status = 'approved'")->fetch_row()[0];
$total_submitted = $conn->query("SELECT COUNT(*) FROM applications WHERE status IS NOT NULL")->fetch_row()[0];

// Fetch applications for display
$sss_applications = $conn->query("SELECT * FROM applications ORDER BY created_at DESC");
$jss_applications = $conn->query("SELECT * FROM jss_applications ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa; /* Light background for the body */
        }
        .sidebar {
            background-color: #ffffff; /* White background for sidebar */
            border-right: 1px solid #dee2e6; /* Border for sidebar */
        }
        .sidebar a {
            color: #007bff; /* Standard link color */
        }
        .sidebar a:hover {
            background-color: #e9ecef; /* Hover effect */
        }
        .active {
            background-color: ; /* Active link color */
            color: white; /* Active link text color */
        }
        .card {
            margin-bottom: 20px; /* Spacing between cards */
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <h4 class="text-center">Dashboard</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#overview" data-toggle="collapse">
                                <span class="material-icons">dashboard</span>
                                Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#applications" data-toggle="collapse">
                                <span class="material-icons">assignment</span>
                                Applications
                            </a>
                            <div class="collapse" id="applications">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#pendingApplications" data-toggle="collapse">
                                            <span class="material-icons">hourglass_empty</span>
                                            Pending Applications (<?php echo $pending_applications; ?>)
                                        </a>
                                        <div class="collapse" id="pendingApplications">
                                            <ul class="nav flex-column pl-3">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#pendingApplicationsTable" data-toggle="collapse">
                                                        View All Pending Applications
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#viewedApplications" data-toggle="collapse">
                                            <span class="material-icons">visibility</span>
                                            Viewed Applications
                                        </a>
                                        <div class="collapse" id="viewedApplications">
                                            <ul class="nav flex-column pl-3">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#viewedApplicationsTable" data-toggle="collapse">
                                                        View All Viewed Applications
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#enquiry" data-toggle="collapse">
                                <span class="material-icons">question_answer</span>
                                Enquiry
                            </a>
                            <div class="collapse" id="enquiry">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="enquiry.php">Manage Enquiries</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#users" data-toggle="collapse">
                                <span class="material-icons">people</span>
                                Users
                            </a>
                            <div class="collapse" id="users">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="users.php">Manage Users</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#admins" data-toggle="collapse">
                                <span class="material-icons">admin_panel_settings</span>
                                Admins
                            </a>
                            <div class="collapse" id="admins">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="admins.php">Manage Admins</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#donors" data-toggle="collapse">
                                <span class="material-icons">people_outline</span>
                                Donors
                            </a>
                            <div class="collapse" id="donors">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="donors.php">Manage Donors</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="collapse show" id="overview">
                    <h2 class="mt-4">Overview</h2>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Total Students</h5>
                                    <p class="card-text"><?php echo $total_students; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Pending Applications</h5>
                                    <p class="card-text"><?php echo $pending_applications; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Approved Applications</h5>
                                    <p class="card-text"><?php echo $approved_applications; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Total Submitted</h5>
                                    <p class="card-text"><?php echo $total_submitted; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse" id="applications">
                    <h2 class="mt-4">Applications</h2>

                    <div class="collapse" id="pendingApplicationsTable">
                        <h4>Pending Applications</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Application</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $pending_applications_list->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['application_text']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td>
                                            <a href="view_application.php?id=<?php echo $row['id']; ?>" class="btn btn-info">View</a>
                                            <button class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Application</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" name="status">
                                                                <option value="approved">Approved</option>
                                                                <option value="rejected">Rejected</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="reason">Reason</label>
                                                            <textarea class="form-control" name="reason" rows="3"><?php echo $row['reason'] ?? ''; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="collapse" id="viewedApplicationsTable">
                        <h4>Viewed Applications</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Application</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $viewed_applications->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['application_text']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <h2 class="mt-4">Applications Overview</h2>

                <h3>SSS Applications</h3>
                <table class="table">
                    <thead>
                        <tr></tr>
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
                                    <a href="view_application.php?id=<?php echo $row['id']; ?>" class="btn btn-info">View</a>
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">Edit</button>
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
                                    <a href="view_application.php?id=<?php echo $row['id']; ?>" class="btn btn-info">View</a>
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <a href="logout.php" class="btn btn-danger">Logout</a>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
