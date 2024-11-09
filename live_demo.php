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

// Get project title from URL
if (isset($_GET['project'])) {
    $projectTitle = $conn->real_escape_string($_GET['project']);

    // Fetch project details from the database
    $sql = "SELECT title, description, programming_language, image, demo_link FROM projects WHERE title = '$projectTitle'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $project = $result->fetch_assoc();
    } else {
        $project = null; // No project found
    }
} else {
    $project = null; // No project title provided
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $project ? htmlspecialchars($project['title']) : 'Project Not Found'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-800">

    <nav class="flex justify-between items-center p-5 bg-gray-800 text-white fixed w-full z-10">
        <div class="flex items-center">
            <img src="img/code.png" alt="Logo" class="h-10 w-10 rounded-full mr-2">
            <div class="font-bold text-lg">My Portfolio</div>
        </div>
        <div class="space-x-4">
            <a href="index.php" class="hover:underline">Home</a>
        </div>
    </nav>

    <header class="flex flex-col items-center justify-center text-center bg-gray-200" style="height: 100vh;">
        <?php if ($project): ?>
            <img src="<?php echo 'admin/uploads/' . htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="h-64 w-full object-cover mb-4">
            <h1 class="text-4xl font-bold"><?php echo htmlspecialchars($project['title']); ?></h1>
            <p class="mt-4 text-lg"><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
            <p class="mt-2 text-gray-500">Programming Language: <?php echo htmlspecialchars($project['programming_language']); ?></p>
            <?php if (!empty($project['demo_link'])): ?>
                <a href="<?php echo htmlspecialchars($project['demo_link']); ?>" class="mt-3 inline-block bg-gray-800 text-white py-2 px-4 rounded hover:bg-gray-700" target="_blank">View Live Demo</a>
            <?php else: ?>
                <p class="mt-3 text-red-500">Live demo link not available.</p>
            <?php endif; ?>
        <?php else: ?>
            <h1 class="text-4xl font-bold">Project Not Found</h1>
            <p class="mt-4">The project you are looking for does not exist.</p>
        <?php endif; ?>
    </header>

    <footer class="p-5 bg-gray-800 text-white text-center">
        <p>&copy; 2024 My Portfolio</p>
    </footer>
</body>

</html>

<?php
$conn->close(); // Close the database connection
?>
