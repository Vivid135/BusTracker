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
    <title>My Profile</title>
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="student.css">
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
    <h1 style="text-align:center; margin-bottom:30px; color:#00796b;">My Profile</h1>
    
   
    
    <div style="max-width:600px; margin:0 auto; background:var(--card-bg); border:1px solid var(--border-color); border-radius:12px; padding:30px;">
        <div style="text-align:center; margin-bottom:20px;">
            <div style="font-size:48px; margin-bottom:10px;">👤</div>
            <h2 style="margin:0 0 10px 0; color:var(--text-primary);">Student Account</h2>
        </div>
        
        <div style="margin-bottom:20px;">
            <p style="font-weight:bold; margin-bottom:5px; color:var(--text-primary);">Account Information</p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['name'] ?? 'Student'); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($_SESSION['role']); ?></p>
            <p><strong>Status:</strong> <span style="color:green;">Active</span></p>
            <p><strong>Account Type:</strong> Student</p>
        </div>
        
        <div style="margin-bottom:20px;">
            <p style="font-weight:bold; margin-bottom:5px; color:var(--text-primary);">Session Information</p>
            <p><strong>Logged in as:</strong> <?php echo htmlspecialchars($_SESSION['name'] ?? 'Student'); ?></p>
            <p><strong>Session started:</strong> <?php echo date('M j, Y h:i A'); ?></p>
            <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
        </div>
    </div>
</div>

<div style="text-align:center; margin:30px 0;">
    <a href="dashboard.php" style="background:var(--button-bg); color:var(--button-text); padding:12px 24px; text-decoration:none; border-radius:6px; font-weight:bold; display:inline-block;">← Back to Dashboard</a>
</div>

<footer class="footer">
    <p>© <?php echo date("Y"); ?> ADBU Student Bus Tracking System | All Rights Reserved</p>
</footer>

<script src="../js/theme.js"></script>
</body>
</html>
