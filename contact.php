<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files (adjust path if needed)
require 'vendor/autoload.php';

// Database connection

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'portfolio';
$conn = new mysqli($host, $user, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'robipastores@gmail.com';
        $mail->Password = 'sxjtsuvhfjituysq'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipient
        $mail->setFrom($email, $name);
        $mail->addAddress('robipastores@gmail.com'); 

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'New Message from Portfolio Contact Form';
        $mail->Body = '
        <div style="
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
            text-align: center;">
            <div style="
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                overflow: hidden;">
                <h2 style="
                    background-color: #1d4ed8;
                    color: #ffffff;
                    padding: 20px;
                    margin: 0;">
                    New Message Received!
                </h2>
                <div style="padding: 20px; text-align: left;">
                    <p><strong>Name:</strong> ' . $name . '</p>
                    <p><strong>Email:</strong> ' . $email . '</p>
                    <p><strong>Message:</strong> ' . nl2br($message) . '</p>
                </div>
                <footer style="
                    background-color: #f3f4f6;
                    padding: 10px;
                    font-size: 14px;
                    color: #6b7280;">
                    Thank you for contacting us! We will get back to you shortly.
                </footer>
            </div>
        </div>';

        $mail->send();

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "<script>
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Message Sent!',
                        text: 'Your message has been sent and saved successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'index.php'; // Redirect after alert
                    });
                }, 100);
            </script>";
        } else {
            echo "<script>
                setTimeout(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Database Error',
                        text: 'Message sent, but failed to save to the database.',
                        confirmButtonText: 'OK'
                    });
                }, 100);
            </script>";
        }
        $stmt->close();
    } catch (Exception $e) {
        echo "<script>
            setTimeout(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Error',
                    text: 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}',
                    confirmButtonText: 'OK'
                });
            }, 100);
        </script>";
    }
}

$conn->close(); // Close the database connection
?>
