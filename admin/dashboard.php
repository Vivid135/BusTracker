<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
        }
        .footer {
            margin-top: auto;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div><img src="../includes/adbu_app_logo_512x512.png" alt="ADBU Logo" style="height:30px; vertical-align:middle; margin-right:10px;"> Assam Don Bosco University Bus Tracker - Admin</div>
    <div>
        <a href="dashboard.php">Dashboard</a> |
        <a href="../logout.php">Logout</a> |
        <button onclick="toggleTheme()" style="background:var(--button-bg); color:var(--button-text); border:none; padding:4px 8px; border-radius:4px; cursor:pointer; font-size:12px;">
            <span id="themeIcon">🌙</span>
        </button>
    </div>
</div>

<div class="container" style="display: flex; flex-direction: column; align-items: center;">
    <h1 style="text-align:center;">Admin Dashboard</h1>

    <div class="card-container" style="width: 100%; max-width: 1200px; display: flex; justify-content: center; flex-wrap: wrap; gap: 20px;">

        <div class="card">
            <h2>Add Bus</h2>
            <p>Create and manage buses</p>
            <a href="add_bus.php" class="btn">Go</a>
        </div>

        <div class="card">
            <h2>Add Route</h2>
            <p>Create bus routes</p>
            <a href="add_route.php" class="btn">Go</a>
        </div>

        <div class="card">
            <h2>Manage Users</h2>
            <p>Block, remove, and manage users</p>
            <a href="manage_users.php" class="btn">Go</a>
        </div>

        <div class="card">
            <h2>Manage Schedules</h2>
            <p>Create and manage bus schedules</p>
            <a href="schedules.php" class="btn">Go</a>
        </div>

    </div>
</div>

<footer class="footer">
    <p>© <?php echo date("Y"); ?> ADBU Student Bus Tracking System | All Rights Reserved</p>
</footer>

<script src="../js/theme.js"></script>
</body>
</html>
