<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $programming_language = $_POST['programming_language'];
    $image = $_FILES['image'];

    // Validate inputs
    if (empty($title) || empty($description) || empty($programming_language) || empty($image['name'])) {
        echo "<script>Swal.fire('Error', 'All fields are required!', 'error');</script>";
    } else {
        // Image upload logic
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($image["tmp_name"]);
        if ($check === false) {
            echo "<script>Swal.fire('Error', 'File is not an image!', 'error');</script>";
            $uploadOk = 0;
        }

        // Check file size (limit to 2MB)
        if ($image["size"] > 2000000) {
            echo "<script>Swal.fire('Error', 'File is too large!', 'error');</script>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>Swal.fire('Error', 'Only JPG, JPEG, PNG & GIF files are allowed!', 'error');</script>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<script>Swal.fire('Error', 'Your file was not uploaded!', 'error');</script>";
        } else {
            // Try to upload file
            if (move_uploaded_file($image["tmp_name"], $target_file)) {
                // Database connection
                $host = 'localhost';
                $user = 'root';
                $password = '';
                $dbname = 'portfolio';
                $conn = new mysqli($host, $user, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Insert project details into database
                $stmt = $conn->prepare("INSERT INTO projects (title, description, image, programming_language) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $title, $description, $target_file, $programming_language);

                if ($stmt->execute()) {
                    echo "<script>Swal.fire('Success', 'Project uploaded successfully!', 'success');</script>";
                } else {
                    echo "<script>Swal.fire('Error', 'Failed to upload project!', 'error');</script>";
                }

                $stmt->close();
                $conn->close();
            } else {
                echo "<script>Swal.fire('Error', 'There was an error uploading your file!', 'error');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 shadow-lg rounded-lg max-w-md w-full">
            <h2 class="text-2xl font-bold text-center mb-6">Upload Project</h2>
            <form method="POST" action="projects.php" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" required 
                        class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" required 
                        class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div>
                    <label for="programming_language" class="block text-sm font-medium text-gray-700">Programming Language</label>
                    <input type="text" name="programming_language" id="programming_language" required 
                        class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image" required 
                        class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" 
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
                    Upload Project
                </button>
            </form>
        </div>
    </div>
</body>
</html>
