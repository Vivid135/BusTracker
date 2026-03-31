<?php
session_start();
include('../config/db.php');

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['submit_report'])){
    $reported_user = mysqli_real_escape_string($conn, $_POST['reported_user']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $reported_by = $_SESSION['user_id'];
    
    mysqli_query($conn, "INSERT INTO user_reports (reported_user, reason, reported_by, status) VALUES ('$reported_user', '$reason', $reported_by, 'pending')");
    header("Location: report_user.php?msg=success");
    exit();
}

$users_result = mysqli_query($conn, "SELECT id, name FROM users WHERE role = 'student' AND id != " . $_SESSION['user_id'] . " ORDER BY name ASC");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Report User</title>
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
    <h1 style="text-align:center; margin-bottom:30px; color:#00796b;">Report</h1>
    
    <?php if(isset($_GET['msg'])): ?>
        <div class="alert" style="background:#4CAF50; color:white; padding:10px; border-radius:4px; margin-bottom:20px; text-align:center;">
            Report submitted successfully. Admin will review it.
        </div>
    <?php endif; ?>
    
    <div style="max-width:600px; margin:0 auto; background:var(--card-bg); border:1px solid var(--border-color); border-radius:12px; padding:30px;">
        <form method="POST" style="display:flex; flex-direction:column; gap:15px;">
            <div>
                <label style="font-weight:bold; margin-bottom:5px; display:block;">Reason for Report:</label>
                <textarea name="reason" required style="width:100%; padding:8px; border:1px solid var(--border-color); border-radius:4px; background:var(--card-bg); color:var(--text-primary); min-height:100px; resize:vertical;" placeholder="Please describe the issue..."></textarea>
            </div>
            
            <div style="text-align:center;">
                <button type="submit" name="submit_report" style="background:#e74c3c; color:white; padding:12px 24px; border:none; border-radius:6px; font-weight:bold; cursor:pointer;">Submit Report</button>
            </div>
        </form>
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
