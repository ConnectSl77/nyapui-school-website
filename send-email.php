<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';  // If using Composer

// If not using Composer, use this:
// require 'path/to/PHPMailerAutoload.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $comment = $_POST['comment'];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                 // Set the SMTP server (use your SMTP server)
        $mail->SMTPAuth = true;                         // Enable SMTP authentication
        $mail->Username = 'magbieprincess@gmail.com';       // SMTP username (your email)
        $mail->Password = 'Paulokon2022';        // SMTP password (your email password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587;                              // TCP port to connect to

        // Recipients
        $mail->setFrom($email, 'Contact Form');          // Sender's email
        $mail->addAddress('magbieprinces@gmail.com');     // Add your email address to receive the message

        // Content
        $mail->isHTML(true);                            // Set email format to HTML
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "Email: $email<br>Phone Number: $phone<br>Comment: $comment"; // HTML message

        // Send email
        $mail->send();
        echo 'Thank you for contacting us! We will get back to you soon.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

