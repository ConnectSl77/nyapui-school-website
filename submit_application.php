<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', 'mysql', 'admin_dashboard');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the source of the form submission
    $source = $_POST['source'];

    // Prepare the SQL statement based on the source
    if ($source === 'sss') {
        $stmt = $conn->prepare("INSERT INTO sss_applications (name, email, dob, place_of_birth, father_name, father_occupation, father_phone, mother_name, mother_occupation, mother_phone, guardian_name, guardian_occupation, guardian_phone, home_address, former_school, career_choice, religion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("ssssssssssssssss", 
            $_POST['name'], 
            $_POST['email'], 
            $_POST['dob'], 
            $_POST['place_of_birth'], // Ensure this matches the form field
            $_POST['father_name'], 
            $_POST['father_occupation'], 
            $_POST['father_phone'], 
            $_POST['mother_name'], 
            $_POST['mother_occupation'], 
            $_POST['mother_phone'], 
            $_POST['guardian_name'], 
            $_POST['guardian_occupation'], 
            $_POST['guardian_phone'], 
            $_POST['home_address'], 
            $_POST['former_school'], 
            $_POST['career_choice'], 
            $_POST['religion']
        );
    } elseif ($source === 'jss') {
        // Prepare and bind for JSS applications
        $stmt = $conn->prepare("INSERT INTO jss_applications (name, dob, place_of_birth, father_name, father_occupation, father_phone, mother_name, mother_occupation, mother_phone, guardian_name, guardian_occupation, guardian_phone, home_address, former_school, npse_scores, career_choice, religion, signature_guardian, signature_pupil) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("ssssssssssssssssss", 
            $_POST['pupilName'], 
            $_POST['dob'], 
            $_POST['place_of_birth'], 
            $_POST['fatherName'], 
            $_POST['fatherOccupation'], 
            $_POST['fatherPhone'], 
            $_POST['motherName'], 
            $_POST['motherOccupation'], 
            $_POST['motherPhone'], 
            $_POST['guardianName'], 
            $_POST['guardianOccupation'], 
            $_POST['guardianPhone'], 
            $_POST['homeAddress'], 
            $_POST['formerSchool'], 
            $_POST['npseScores'], 
            $_POST['careerChoice'], 
            $_POST['religion'], 
            $_POST['signature_guardian'], 
            $_POST['signature_pupil']
        );
    }

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        header("Location: success.php"); // Create a success.php page to show a success message
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>