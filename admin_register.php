<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'portfolio';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Handle Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO admins (name, email, password) VALUES ('$name', '$email', '$password')";

    if ($conn->query($query)) {
        echo "<script>
                Swal.fire('Success', 'Registration successful!', 'success')
                .then(() => window.location = 'admin_login.php');
              </script>";
    } else {
        echo "<script>Swal.fire('Error', 'Failed to register admin!', 'error');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-r from-green-400 to-blue-500 min-h-screen">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-xl shadow-lg max-w-lg w-full">
            <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Create Admin Account</h2>
            <form method="POST" action="admin_register.php" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" id="name" required 
                        class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" id="email" required 
                        class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required 
                        class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" 
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
                    Register
                </button>
            </form>
            <p class="mt-6 text-center text-gray-600">
                Already have an account? 
                <a href="admin_login.php" class="text-blue-500 hover:underline">Login</a>
            </p>
        </div>
    </div>
</body>
</html>
