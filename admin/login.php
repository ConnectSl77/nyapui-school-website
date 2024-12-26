<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', 'mysql', 'admin_dashboard');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check admin credentials
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}

// Database connection
$conn = new mysqli('localhost', 'root', 'mysql', 'admin_dashboard');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Admin credentials
$username = 'nyapui';
$password = 'admin';

// Check if the admin already exists
$stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) { // Only insert if the username does not exist
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New admin created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Admin with this username already exists.";
}

// Close the connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <div class="container mx-auto mt-10 max-w-md">
        <div class="bg-white rounded-lg shadow-md p-6">
            <img src="path/to/your/image.png" alt="Logo" class="mx-auto mb-5">
            <h2 class="text-center text-2xl font-bold mb-5">Admin Login</h2>
            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="POST">
                <div class="form-group mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <div class="relative">
                        <input type="text" class="form-control pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="username" required>
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="material-icons">person</i>
                        </span>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input type="password" class="form-control pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="password" required>
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="material-icons">lock</i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-full bg-blue-600 text-white rounded-md hover:bg-blue-700">Login</button>
            </form>
            <p class="text-center mt-4">Don't have an account? <a href="#" class="text-blue-500">Register here</a></p>
        </div>
    </div>
</body>
</html>
