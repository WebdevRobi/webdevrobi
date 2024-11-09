<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white h-screen shadow-lg">
        <div class="flex items-center justify-center py-4">
            <img src=",/img/code.png" alt="Logo" class="h-16">
        </div>
        <nav class="mt-6">
            <ul>
                <li>
                    <a href="admin_dashboard.php" class="flex items-center p-4 text-gray-700 hover:bg-gray-200">
                        <span class="material-icons"></span>
                        <span class="ml-2">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="projects.php" class="flex items-center p-4 text-gray-700 hover:bg-gray-200">
                        <span class="material-icons"></span>
                        <span class="ml-2">Projects</span>
                    </a>
                </li>
                <li>
                    <a href="users.php" class="flex items-center p-4 text-gray-700 hover:bg-gray-200">
                        <span class="material-icons"></span>
                        <span class="ml-2">Users</span>
                    </a>
                </li>
                <li>
                    <a href="settings.php" class="flex items-center p-4 text-gray-700 hover:bg-gray-200">
                        <span class="material-icons"></span>
                        <span class="ml-2">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="flex items-center p-4 text-red-600 hover:bg-red-100">
                        <span class="material-icons"></span>
                        <span class="ml-2">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <nav class="flex items-center justify-between">
            <h1 class="text-3xl font-bold">Welcome, <?php echo $_SESSION['admin_name']; ?>!</h1>
        </nav>
        
        <div class="mt-8">
            <h2 class="text-2xl font-semibold">Dashboard Overview</h2>
            <!-- Dashboard content goes here -->
            <div class="mt-4 bg-white p-4 rounded-lg shadow">
                <p>This is the dashboard content area.</p>
            </div>
        </div>
    </div>
</body>
</html>
