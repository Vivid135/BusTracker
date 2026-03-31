<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="student.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>

<div class="navbar">
    <div><img src="../includes/adbu_app_logo_512x512.png" alt="ADBU Logo" style="height:30px; vertical-align:middle; margin-right:10px;"> Assam Don Bosco University Bus Tracker</div>
    <div>
        <a href="dashboard.php">Dashboard</a> |
        <a href="../logout.php">Logout</a> |
        <button onclick="toggleTheme()" style="background:var(--button-bg); color:var(--button-text); border:none; padding:4px 8px; border-radius:4px; cursor:pointer; font-size:12px;">
            <span id="themeIcon">🌙</span>
        </button>
    </div>
</div>

<div class="container">
    <h1 style="text-align:center; margin-bottom:30px; color:#00796b;">Welcome, Student</h1>
    
    <div class="dashboard-grid">
        <div class="card">
            <div class="card-icon">📍</div>
            <div class="card-content">
                <h3>Track Bus Live</h3>
                <p>See real-time bus location on map</p>
                <a class="button" href="track_bus.php">Track Now</a>
            </div>
        </div>

        <div class="card">
            <div class="card-icon">📅</div>
            <div class="card-content">
                <h3>Bus Schedules</h3>
                <p>View daily bus schedules</p>
                <a class="button" href="schedules.php">View Schedules</a>
            </div>
        </div>

        <div class="card">
            <div class="card-icon">👤</div>
            <div class="card-content">
                <h3>My Profile</h3>
                <p>View your account details</p>
                <a class="button" href="profile.php">View Profile</a>
            </div>
        </div>

        <div class="card">
            <div class="card-icon">📋</div>
            <div class="card-content">
                <h3>Report</h3>
                <p>Report inappropriate behavior or issues</p>
                <a class="button" href="report_user.php">Report</a>
            </div>
        </div>
    </div>
</div>

<script>

window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    document.body.innerHTML += '<div style="position:fixed; top:10px; right:10px; background:red; color:white; padding:10px; border-radius:4px; z-index:9999;">JS Error: ' + e.error.message + '</div>';
});

document.addEventListener('click', function(e) {
    if(e.target.tagName === 'A' && e.target.href) {
        console.log('Navigation clicked:', e.target.href);
    }
});

console.log('Dashboard loaded successfully');
</script>

<footer class="footer">
    <p> <?php echo date("Y"); ?> ADBU Student Bus Tracking System | All Rights Reserved</p>
</footer>

<script src="../js/theme.js"></script>
</body>
</html>
