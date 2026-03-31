<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Bus Tracking System</title>
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<nav class="navbar">
    <div class="logo"><img src="includes/adbu_app_logo_512x512.png" alt="ADBU Logo" style="height:30px; vertical-align:middle; margin-right:10px;">ADBU Bus Tracker</div>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>

        <?php if(isset($_SESSION['user_id'])): ?>
            
            <?php if($_SESSION['role'] == 'admin'): ?>
                <li><a href="admin/dashboard.php">Dashboard</a></li>
            <?php else: ?>
                <li><a href="student/dashboard.php">Dashboard</a></li>
            <?php endif; ?>

            <li><a href="logout.php">Logout</a></li>

        <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>

        <li><a href="contact.php">Contact</a></li>
        <li><button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
            <svg class="sun-icon" viewBox="0 0 24 24" style="display: none;">
                <path d="M12 17.5C9.5 17.5 7.5 15.5 7.5 13S9.5 8.5 12 8.5 16.5 10.5 16.5 13 14.5 17.5 12 17.5M12 7C8.7 7 6 9.7 6 13S8.7 19 12 19 18 16.3 18 13 15.3 7 12 7M12 2L14.4 6.4L19 5.7L16.2 9.8L18.6 14L14 12.3L9.4 14L11.8 9.8L9 5.7L13.6 6.4L12 2Z"/>
            </svg>
            <svg class="moon-icon" viewBox="0 0 24 24">
                <path d="M17.75,4.09L15.22,6.03L16.13,9.09L13.5,7.28L10.87,9.09L11.78,6.03L9.25,4.09L12.44,4L13.5,1L14.56,4L17.75,4.09M21.25,11L19.61,12.25L20.2,14.23L18.5,13.06L16.8,14.23L17.39,12.25L15.75,11L17.81,10.95L18.5,9L19.19,10.95L21.25,11M18.97,15.95C19.8,15.87 20.69,17.05 20.16,17.8C19.84,18.25 19.5,18.67 19.08,19.07C15.17,23 8.84,23 4.94,19.07C1.03,15.17 1.03,8.83 4.94,4.93C5.34,4.53 5.76,4.17 6.21,3.85C6.96,3.32 8.14,4.21 8.06,5.04C7.79,7.9 8.75,10.87 10.95,13.06C13.14,15.26 16.1,16.22 18.97,15.95M17.33,17.97C14.5,17.81 11.7,16.64 9.53,14.5C7.36,12.31 6.2,9.5 6.04,6.68C3.23,9.82 3.34,14.64 6.35,17.66C9.37,20.67 14.19,20.78 17.33,17.97Z"/>
            </svg>
        </button></li>
    </ul>
</nav>

<section class="hero">
    <div class="hero-content">
        <h1>ADBU Student Bus Tracking System</h1>
        <p>Track university buses easily and safely.</p>

        <?php if(!isset($_SESSION['user_id'])): ?>
            <a href="register.php" class="btn">Get Started</a>
        <?php endif; ?>
    </div>
</section>

<footer class="footer">
    <p>  <?php echo date("Y"); ?> ADBU Student Bus Tracking System | All Rights Reserved</p>
</footer>

<script src="js/theme.js"></script>
</body>
</html>