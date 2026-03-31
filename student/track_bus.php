<?php
session_start();
include('../config/db.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}

$latest = mysqli_fetch_assoc(mysqli_query($conn, "SELECT bl.*, b.bus_number FROM bus_locations bl JOIN buses b ON b.id = bl.bus_id ORDER BY bl.updated_at DESC LIMIT 1"));
$lat = $latest ? (float)$latest['latitude'] : 26.7082;
$lng = $latest ? (float)$latest['longitude'] : 92.7880;
$bus_number = $latest ? $latest['bus_number'] : 'No active buses right now';
$last_update = $latest ? $latest['updated_at'] : 'Never';

$all_buses_result = mysqli_query($conn, "SELECT b.bus_number, r.route_name, b.status FROM buses b LEFT JOIN routes r ON r.id = b.route_id ORDER BY b.bus_number ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Bus</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
    <h1>Track Bus Live</h1>
    
    <p><strong>MAP</strong></p>
    <div id="map" style="width:100%; height:500px; border:1px solid #ccc; border-radius:8px;"></div>
    <p style="font-size:12px; color:#666; text-align:center; margin-top:10px;">Live tracking - updates automatically every 3 seconds.</p>
</div>

<div class="container" style="margin-top:30px;">
    <h3>All Buses</h3>
    <table id="busesTable" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Bus Number</th>
                <th>Route</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if($all_buses_result && mysqli_num_rows($all_buses_result) > 0): ?>
                <?php while($bus = mysqli_fetch_assoc($all_buses_result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($bus['bus_number']); ?></td>
                        <td><?php echo htmlspecialchars($bus['route_name']); ?></td>
                        <td><?php echo htmlspecialchars($bus['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align:center; padding:20px; color:#666;">No buses found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    <?php if($all_buses_result && mysqli_num_rows($all_buses_result) > 0): ?>
    $('#busesTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']],
        ordering: false,
        language: {
            search: "Search buses...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ buses",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });
    <?php endif; ?>
    
    setInterval(function() {
        location.reload();
    }, 3000);
});
</script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
var map;
var marker;
var routePoints = [
    {lat: 26.7082, lng: 92.7880},
    {lat: 26.7095, lng: 92.7895},
    {lat: 26.7108, lng: 92.7910},
    {lat: 26.7121, lng: 92.7925},
    {lat: 26.7134, lng: 92.7940}
];
var pointIndex = 0;

function initMap(){
    map = L.map('map').setView([<?php echo $lat; ?>, <?php echo $lng; ?>], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    
    marker = L.marker([<?php echo $lat; ?>, <?php echo $lng; ?>]).addTo(map)
        .bindPopup('<strong><?php echo addslashes($bus_number); ?></strong><br>Last update: <?php echo addslashes($last_update); ?>');
}

window.onload = initMap;
</script>

<div style="text-align:center; margin:30px 0;">
    <a href="dashboard.php" style="background:var(--button-bg); color:var(--button-text); padding:12px 24px; text-decoration:none; border-radius:6px; font-weight:bold; display:inline-block;">← Back to Dashboard</a>
</div>

<footer class="footer">
    <p> <?php echo date("Y"); ?> ADBU Student Bus Tracking System | All Rights Reserved</p>
</footer>

<script src="../js/theme.js"></script>
</body>
</html>
