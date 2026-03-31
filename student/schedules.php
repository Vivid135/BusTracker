<?php
session_start();
include('../config/db.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}

$schedules_result = mysqli_query($conn, "SELECT s.id, s.day, s.departure_time, s.arrival_time, b.bus_number, r.route_name FROM bus_schedules s LEFT JOIN buses b ON b.id=s.bus_id LEFT JOIN routes r ON r.id=s.route_id ORDER BY FIELD(s.day,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'), s.departure_time ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Schedules</title>
    <link rel="stylesheet" href="../css/theme.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="student.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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
    <h2>Bus Schedules</h2>

    <table id="schedulesTable" border="1" cellpadding="8" cellspacing="0" style="width:100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Bus</th>
                <th>Route</th>
                <th>Day</th>
                <th>Departure</th>
                <th>Arrival</th>
            </tr>
        </thead>
        <tbody>
            <?php if($schedules_result && mysqli_num_rows($schedules_result) > 0): ?>
                <?php while($schedule = mysqli_fetch_assoc($schedules_result)): ?>
                    <tr>
                        <td><?php echo $schedule['id']; ?></td>
                        <td><?php echo htmlspecialchars($schedule['bus_number']); ?></td>
                        <td><?php echo htmlspecialchars($schedule['route_name']); ?></td>
                        <td><?php echo $schedule['day']; ?></td>
                        <td><?php echo date('h:i A', strtotime($schedule['departure_time'])); ?></td>
                        <td><?php echo date('h:i A', strtotime($schedule['arrival_time'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding:20px; color:#666;">No schedules found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <script>
    $(document).ready(function() {
        <?php if($schedules_result && mysqli_num_rows($schedules_result) > 0): ?>
        $('#schedulesTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[4, 'asc']],
            language: {
                search: "Search schedules...",
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                info: "Showing _START_ to _END_ of _TOTAL_ schedules",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });
        <?php endif; ?>
    });
    </script>
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
