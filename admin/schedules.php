<?php
session_start();
include('../config/db.php');

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

if(isset($_GET['delete_id'])){
    $delete_id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM bus_schedules WHERE id=$delete_id");
    header("Location: schedules.php");
    exit();
}

$edit_schedule = null;
if(isset($_GET['edit_id'])){
    $edit_id = (int)$_GET['edit_id'];
    $result = mysqli_query($conn, "SELECT * FROM bus_schedules WHERE id=$edit_id");
    $edit_schedule = mysqli_fetch_assoc($result);
}

if(isset($_POST['add'])){
    $bus_id = null;
    if(isset($_POST['bus_id']) && $_POST['bus_id'] !== ''){
        $bus_id = (int)$_POST['bus_id'];
    }

    $route_id = null;
    if(isset($_POST['route_id']) && $_POST['route_id'] !== ''){
        $route_id = (int)$_POST['route_id'];
    }

    $day = $_POST['day'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];

    $bus_id_sql = ($bus_id === null) ? "NULL" : (string)$bus_id;
    $route_id_sql = ($route_id === null) ? "NULL" : (string)$route_id;

    mysqli_query($conn, "INSERT INTO bus_schedules (bus_id, route_id, day, departure_time, arrival_time) VALUES ($bus_id_sql, $route_id_sql, '$day', '$departure_time', '$arrival_time')");
    header("Location: schedules.php?success=1");
    exit();
}

if(isset($_POST['update'])){
    $schedule_id = (int)$_POST['schedule_id'];
    
    $bus_id = null;
    if(isset($_POST['bus_id']) && $_POST['bus_id'] !== ''){
        $bus_id = (int)$_POST['bus_id'];
    }

    $route_id = null;
    if(isset($_POST['route_id']) && $_POST['route_id'] !== ''){
        $route_id = (int)$_POST['route_id'];
    }

    $day = $_POST['day'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];

    $bus_id_sql = ($bus_id === null) ? "NULL" : (string)$bus_id;
    $route_id_sql = ($route_id === null) ? "NULL" : (string)$route_id;

    mysqli_query($conn, "UPDATE bus_schedules SET bus_id=$bus_id_sql, route_id=$route_id_sql, day='$day', departure_time='$departure_time', arrival_time='$arrival_time' WHERE id=$schedule_id");
    header("Location: schedules.php?success=2");
    exit();
}

$buses_result = mysqli_query($conn, "SELECT id, bus_number FROM buses ORDER BY bus_number ASC");
$routes_result = mysqli_query($conn, "SELECT id, route_name FROM routes ORDER BY route_name ASC");
$schedules_result = mysqli_query($conn, "SELECT s.id, s.day, s.departure_time, s.arrival_time, b.bus_number, r.route_name FROM bus_schedules s LEFT JOIN buses b ON b.id=s.bus_id LEFT JOIN routes r ON r.id=s.route_id ORDER BY s.id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Schedules</title>
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
    <h1 style="text-align:center;">Bus Schedules</h1>
    
    <?php if(isset($_GET['success'])): ?>
        <div style="background:#28a745; color:white; padding:12px; border-radius:6px; margin-bottom:20px; text-align:center; font-weight:bold;">
            <?php 
            if($_GET['success'] == '1') echo "Schedule added successfully!";
            elseif($_GET['success'] == '2') echo "Schedule updated successfully!";
            ?>
        </div>
    <?php endif; ?>

    <div style="max-width:600px; margin:0 auto; background:var(--card-bg); border:1px solid var(--border-color); border-radius:12px; padding:30px; margin-bottom:30px;">
        <h2 style="text-align:center; margin-bottom:20px;"><?php echo $edit_schedule ? 'Edit Schedule' : 'Add Schedule'; ?></h2>
        <form method="POST" style="display:flex; flex-direction:column; gap:20px;">
            <?php if($edit_schedule): ?>
                <input type="hidden" name="schedule_id" value="<?php echo $edit_schedule['id']; ?>">
            <?php endif; ?>
            
            <div>
                <label style="font-weight:bold; margin-bottom:5px; display:block;">Bus:</label>
                <select name="bus_id" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; background:var(--card-bg); color:var(--text-primary);">
                    <option value="">-- Select Bus --</option>
                    <?php if($buses_result): ?>
                        <?php while($bus = mysqli_fetch_assoc($buses_result)): ?>
                            <option value="<?php echo $bus['id']; ?>" <?php echo ($edit_schedule && $edit_schedule['bus_id'] == $bus['id']) ? 'selected' : ''; ?>><?php echo $bus['bus_number']; ?></option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label style="font-weight:bold; margin-bottom:5px; display:block;">Route:</label>
                <select name="route_id" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; background:var(--card-bg); color:var(--text-primary);">
                    <option value="">-- Select Route --</option>
                    <?php if($routes_result): ?>
                        <?php while($route = mysqli_fetch_assoc($routes_result)): ?>
                            <option value="<?php echo $route['id']; ?>" <?php echo ($edit_schedule && $edit_schedule['route_id'] == $route['id']) ? 'selected' : ''; ?>><?php echo $route['route_name']; ?></option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label style="font-weight:bold; margin-bottom:5px; display:block;">Day:</label>
                <select name="day" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; background:var(--card-bg); color:var(--text-primary);">
                    <option value="Monday" <?php echo ($edit_schedule && $edit_schedule['day'] == 'Monday') ? 'selected' : ''; ?>>Monday</option>
                    <option value="Tuesday" <?php echo ($edit_schedule && $edit_schedule['day'] == 'Tuesday') ? 'selected' : ''; ?>>Tuesday</option>
                    <option value="Wednesday" <?php echo ($edit_schedule && $edit_schedule['day'] == 'Wednesday') ? 'selected' : ''; ?>>Wednesday</option>
                    <option value="Thursday" <?php echo ($edit_schedule && $edit_schedule['day'] == 'Thursday') ? 'selected' : ''; ?>>Thursday</option>
                    <option value="Friday" <?php echo ($edit_schedule && $edit_schedule['day'] == 'Friday') ? 'selected' : ''; ?>>Friday</option>
                    <option value="Saturday" <?php echo ($edit_schedule && $edit_schedule['day'] == 'Saturday') ? 'selected' : ''; ?>>Saturday</option>
                    <option value="Sunday" <?php echo ($edit_schedule && $edit_schedule['day'] == 'Sunday') ? 'selected' : ''; ?>>Sunday</option>
                </select>
            </div>

            <div>
                <label style="font-weight:bold; margin-bottom:5px; display:block;">Departure Time:</label>
                <input type="time" name="departure_time" required value="<?php echo $edit_schedule ? $edit_schedule['departure_time'] : ''; ?>" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; background:var(--card-bg); color:var(--text-primary);">
            </div>

            <div>
                <label style="font-weight:bold; margin-bottom:5px; display:block;">Arrival Time:</label>
                <input type="time" name="arrival_time" required value="<?php echo $edit_schedule ? $edit_schedule['arrival_time'] : ''; ?>" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; background:var(--card-bg); color:var(--text-primary);">
            </div>

            <div style="text-align:center;">
                <button name="<?php echo $edit_schedule ? 'update' : 'add'; ?>" style="background:var(--button-bg); color:var(--button-text); padding:12px 24px; border:none; border-radius:6px; font-weight:bold; cursor:pointer;">
                    <?php echo $edit_schedule ? 'Update Schedule' : 'Add Schedule'; ?>
                </button>
                <?php if($edit_schedule): ?>
                    <a href="schedules.php" style="margin-left:10px; background:#6c757d; color:white; padding:12px 24px; text-decoration:none; border-radius:6px; font-weight:bold; display:inline-block;">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <br>

    <h2 style="text-align:center; margin-top:40px; margin-bottom:20px;">All Schedules</h2>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; background:var(--card-bg); border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background:linear-gradient(135deg, var(--button-bg), var(--button-hover)); color:white;">
                    <th style="padding:12px; text-align:left; font-weight:bold;">ID</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Bus</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Route</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Day</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Departure</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Arrival</th>
                    <th style="padding:12px; text-align:center; font-weight:bold;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($schedules_result && mysqli_num_rows($schedules_result) > 0): ?>
                    <?php while($s = mysqli_fetch_assoc($schedules_result)): ?>
                        <tr style="border-bottom:1px solid var(--border-color); transition:background-color 0.2s;" onmouseover="this.style.backgroundColor='var(--bg-secondary)'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding:12px;"><?php echo $s['id']; ?></td>
                            <td style="padding:12px; font-weight:500;"><?php echo $s['bus_number']; ?></td>
                            <td style="padding:12px;"><?php echo $s['route_name']; ?></td>
                            <td style="padding:12px;">
                                <span style="padding:4px 8px; border-radius:4px; font-size:12px; font-weight:bold; background:var(--button-bg); color:white;">
                                    <?php echo $s['day']; ?>
                                </span>
                            </td>
                            <td style="padding:12px;"><?php echo date('h:i A', strtotime($s['departure_time'])); ?></td>
                            <td style="padding:12px;"><?php echo date('h:i A', strtotime($s['arrival_time'])); ?></td>
                            <td style="padding:12px; text-align:center;">
                                <a href="schedules.php?edit_id=<?php echo $s['id']; ?>" 
                                   style="background:#007bff; color:white; padding:6px 12px; text-decoration:none; border-radius:4px; font-size:12px; font-weight:bold; margin-right:4px; transition:background-color 0.2s;"
                                   onmouseover="this.style.backgroundColor='#0056b3'"
                                   onmouseout="this.style.backgroundColor='#007bff'">
                                    Edit
                                </a>
                                <a href="schedules.php?delete_id=<?php echo $s['id']; ?>" 
                                   onclick="return confirm('Delete this schedule?');" 
                                   style="background:#dc3545; color:white; padding:6px 12px; text-decoration:none; border-radius:4px; font-size:12px; font-weight:bold; transition:background-color 0.2s;"
                                   onmouseover="this.style.backgroundColor='#c82333'"
                                   onmouseout="this.style.backgroundColor='#dc3545'">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center; padding:30px; color:var(--text-secondary); font-style:italic;">No schedules added yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
