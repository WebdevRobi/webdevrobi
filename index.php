<?php
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

// Fetch projects from the database
$sql = "SELECT title, description, programming_language, image FROM projects ORDER BY created_at ASC";
$result = $conn->query($sql);

// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files (adjust path if needed)
require 'vendor/autoload.php';

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include 'web_icon.php'; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robi Pastores</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-800 transition-colors duration-500" id="body">

    <nav class="flex justify-between items-center p-5 bg-gray-800 text-white fixed w-full z-10">
        <div class="flex items-center">
            <img src="img/code.png" alt="Logo" class="h-10 w-10 rounded-full mr-2">
            <div class="font-bold text-lg">Robi Pastores</div>
        </div>
        <div class="space-x-4">
            <a href="#projects" class="hover:underline">Projects</a>
            <a href="#about" class="hover:underline">About</a>
            <a href="#contact" class="hover:underline">Contact</a>
        </div>
        <button id="toggle" class="bg-transparent border-0 text-white text-xl focus:outline-none">🌙</button>
    </nav>

    <header class="flex flex-col items-center justify-center text-center bg-gray-200 relative" style="height: 100vh;">
        <img src="img/landingpage.jpg" alt="Welcome Image" class="h-full w-full object-cover mb-[-50px] z-0">
        <div class="relative z-10 p-6">
            <h1 class="text-4xl font-bold">Welcome to My Portfolio</h1>
            <p class="mt-4 text-lg">I'm a Web App Developer. Building beautiful and functional websites.</p>
            
            <!-- CV Download Button -->
            <a href="cv/CV-RobiPastores.docx" download class="mt-6 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-500">Download CV</a>
            
            <!-- Get Free Quote Button -->
            <a href="index.php" class="mt-4 inline-block bg-green-600 text-white py-2 px-4 rounded hover:bg-green-500">Get Free Quote</a>
        </div>
    </header>
    <br>
    <br>

    <section class="p-10 bg-white" id="projects">
        <h2 class="text-3xl font-bold text-center">My Projects</h2>
        <div class="flex justify-center flex-wrap mt-8">

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="m-4 p-5 border rounded-lg shadow-lg transform transition duration-300 hover:scale-105">
                    <?php 
                        $imagePath = 'admin/' . htmlspecialchars($row['image']); 
                    ?>
                    <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="w-full h-48 object-cover rounded mb-2" onerror="this.onerror=null;this.src='path_to_placeholder_image.jpg';">
                    <h3 class="font-semibold"><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p class="mt-2"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                    <p class="mt-2 text-gray-500">Programming Language: 
                        <?php 
                        // Assuming programming_language contains comma-separated values
                        $programmingLanguages = explode(',', htmlspecialchars($row['programming_language'])); 
                        foreach ($programmingLanguages as $language): 
                        ?>
                        <span class="flex items-center mr-2">
                            <?php if (trim($language) == 'PHP'): ?>
                                <img src="img/icons/php-logo.png" alt="PHP" class="h-5 w-5 mr-1" />
                            <?php elseif (trim($language) == 'Mysql'): ?>
                                <img src="img/icons/mysql-logo.png" alt="Mysql" class="h-5 w-5 mr-1" />
                            <?php elseif (trim($language) == 'Javascript'): ?>
                                <img src="img/icons/javascript-logo.png" alt="Javascript" class="h-5 w-5 mr-1" />
                            <?php elseif (trim($language) == 'React JS'): ?>
                                <img src="img/icons/react-logo.png" alt="React" class="h-5 w-5 mr-1" />
                            <?php elseif (trim($language) == 'Tailwind Css'): ?>
                                <img src="img/icons/tailwind-logo.png" alt="CSS" class="h-5 w-5 mr-1" />
                            <?php elseif (trim($language) == 'HTML'): ?>
                                <img src="img/icons/html-logo.png" alt="HTML" class="h-5 w-5 mr-1" />
                            <?php endif; ?>
                            <span><?php echo trim($language); ?></span>
                        </span>
                        <?php endforeach; ?>
                    </p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No projects found.</p>
        <?php endif; ?>

        </div>
    </section>

    <!-- About Me Section -->
    <section class="p-10 bg-gray-200" id="about">
        <h2 class="text-3xl font-bold text-center">About Me</h2>
        <div class="mt-8 max-w-4xl mx-auto text-center">
            <p class="text-lg">
                Hello! I'm Robi Pastores, a passionate web developer with a knack for creating dynamic and beautiful web applications. My journey in web development began during college capstone/thesis. I love coding and enjoy solving complex problems. When I'm not coding, I spend my time for playing basketball and cooking. I’m excited to bring my skills to new projects and collaborate with others!
            </p>
        </div>
    </section>

    <section class="p-10 bg-white" id="contact">
        <h2 class="text-3xl font-bold text-center">Contact Me</h2>
        <form method="POST" action="" class="max-w-lg mx-auto mt-8">
            <input type="text" name="name" placeholder="Your Name" required class="block w-full p-2 border border-gray-400 rounded mb-4">
            <input type="email" name="email" placeholder="Your Email" required class="block w-full p-2 border border-gray-400 rounded mb-4">
            <textarea name="message" placeholder="Your Message" required class="block w-full p-2 border border-gray-400 rounded mb-4"></textarea>
            <button type="submit" name="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-500">Send Message</button>
        </form>
    </section>

    <footer class="text-center p-5 bg-gray-800 text-white mt-10">
        <p>&copy; <?php echo date("Y"); ?> Robi Pastores. All Rights Reserved.</p>
    </footer>

    <script>
        // Dark mode toggle
        const toggle = document.getElementById('toggle');
        const body = document.getElementById('body');

        toggle.addEventListener('click', () => {
            body.classList.toggle('bg-gray-800');
            body.classList.toggle('text-white');
            body.classList.toggle('bg-gray-100');
            body.classList.toggle('text-gray-800');
            toggle.textContent = toggle.textContent === '🌙' ? '☀️' : '🌙';
        });
    </script>
</body>

</html>
