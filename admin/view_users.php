<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') 
{
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Users</title>
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

<div class="container">
    <h2>All Users</h2>

    <table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Student ID</th>
        <th>Email</th>
        <th>Department</th>
        <th>Year</th>
        <th>Phone</th>
        <th>Emergency</th>
        <th>Role</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?= $row['id']; ?></td>
        <td><?= $row['name']; ?></td>
        <td><?= $row['student_id']; ?></td>
        <td><?= $row['email']; ?></td>
        <td><?= $row['department']; ?></td>
        <td><?= $row['year']; ?></td>
        <td><?= $row['phone']; ?></td>
        <td><?= $row['emergency_contact']; ?></td>
        <td><?= $row['role']; ?></td>
    </tr>
    <?php } ?>

    </table>
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

