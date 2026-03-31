<?php
include('../config/db.php');

if(isset($_GET['delete_id'])){
    $delete_id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM routes WHERE id=$delete_id");
    header("Location: add_route.php");
    exit();
}

$edit_route = null;
if(isset($_GET['edit_id'])){
    $edit_id = (int)$_GET['edit_id'];
    $result = mysqli_query($conn, "SELECT * FROM routes WHERE id=$edit_id");
    $edit_route = mysqli_fetch_assoc($result);
}

if(isset($_POST['add'])){
    $route_name = $_POST['route_name'];
    $start_point = $_POST['start_point'];
    $end_point = $_POST['end_point'];

    mysqli_query($conn,"INSERT INTO routes (route_name,start_point,end_point)
    VALUES ('$route_name','$start_point','$end_point')");

    header("Location: add_route.php?success=1");
    exit();
}

if(isset($_POST['update'])){
    $route_id = (int)$_POST['route_id'];
    $route_name = $_POST['route_name'];
    $start_point = $_POST['start_point'];
    $end_point = $_POST['end_point'];

    mysqli_query($conn,"UPDATE routes SET route_name='$route_name', start_point='$start_point', end_point='$end_point' WHERE id=$route_id");

    header("Location: add_route.php?success=2");
    exit();
}

$routes_result = mysqli_query($conn, "SELECT id, route_name, start_point, end_point FROM routes ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Route</title>
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
    <h1 style="text-align:center;"><?php echo $edit_route ? 'Edit Route' : 'Add Route'; ?></h1>
    
    <?php if(isset($_GET['success'])): ?>
        <div style="background:#28a745; color:white; padding:12px; border-radius:6px; margin-bottom:20px; text-align:center; font-weight:bold;">
            <?php 
            if($_GET['success'] == '1') echo "Route added successfully!";
            elseif($_GET['success'] == '2') echo "Route updated successfully!";
            ?>
        </div>
    <?php endif; ?>

    <div style="max-width:600px; margin:0 auto; background:var(--card-bg); border:1px solid var(--border-color); border-radius:12px; padding:30px; margin-bottom:30px;">
        <form method="POST" style="display:flex; flex-direction:column; gap:20px;">
            <?php if($edit_route): ?>
                <input type="hidden" name="route_id" value="<?php echo $edit_route['id']; ?>">
            <?php endif; ?>
            
            <div>
                <label style="font-weight:bold; margin-bottom:5px; display:block;">Route Name:</label>
                <input type="text" name="route_name" required value="<?php echo $edit_route ? htmlspecialchars($edit_route['route_name']) : ''; ?>" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; background:var(--card-bg); color:var(--text-primary);">
            </div>

            <div>
                <label style="font-weight:bold; margin-bottom:5px; display:block;">Start Point:</label>
                <input type="text" name="start_point" required value="<?php echo $edit_route ? htmlspecialchars($edit_route['start_point']) : ''; ?>" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; background:var(--card-bg); color:var(--text-primary);">
            </div>

            <div>
                <label style="font-weight:bold; margin-bottom:5px; display:block;">End Point:</label>
                <input type="text" name="end_point" required value="<?php echo $edit_route ? htmlspecialchars($edit_route['end_point']) : ''; ?>" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; background:var(--card-bg); color:var(--text-primary);">
            </div>

            <div style="text-align:center;">
                <button name="<?php echo $edit_route ? 'update' : 'add'; ?>" style="background:var(--button-bg); color:var(--button-text); padding:12px 24px; border:none; border-radius:6px; font-weight:bold; cursor:pointer;">
                    <?php echo $edit_route ? 'Update Route' : 'Add Route'; ?>
                </button>
                <?php if($edit_route): ?>
                    <a href="add_route.php" style="margin-left:10px; background:#6c757d; color:white; padding:12px 24px; text-decoration:none; border-radius:6px; font-weight:bold; display:inline-block;">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <br>

    <h2 style="text-align:center; margin-top:40px; margin-bottom:20px;">All Routes</h2>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; background:var(--card-bg); border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background:linear-gradient(135deg, var(--button-bg), var(--button-hover)); color:white;">
                    <th style="padding:12px; text-align:left; font-weight:bold;">ID</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Route Name</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Start Point</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">End Point</th>
                    <th style="padding:12px; text-align:center; font-weight:bold;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($routes_result && mysqli_num_rows($routes_result) > 0): ?>
                    <?php while($route = mysqli_fetch_assoc($routes_result)): ?>
                        <tr style="border-bottom:1px solid var(--border-color); transition:background-color 0.2s;" onmouseover="this.style.backgroundColor='var(--bg-secondary)'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding:12px;"><?php echo $route['id']; ?></td>
                            <td style="padding:12px; font-weight:500;"><?php echo $route['route_name']; ?></td>
                            <td style="padding:12px;"><?php echo $route['start_point']; ?></td>
                            <td style="padding:12px;"><?php echo $route['end_point']; ?></td>
                            <td style="padding:12px; text-align:center;">
                                <a href="add_route.php?edit_id=<?php echo $route['id']; ?>" 
                                   style="background:#007bff; color:white; padding:6px 12px; text-decoration:none; border-radius:4px; font-size:12px; font-weight:bold; margin-right:4px; transition:background-color 0.2s;"
                                   onmouseover="this.style.backgroundColor='#0056b3'"
                                   onmouseout="this.style.backgroundColor='#007bff'">
                                    Edit
                                </a>
                                <a href="add_route.php?delete_id=<?php echo $route['id']; ?>" 
                                   onclick="return confirm('Delete this route?');" 
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
                        <td colspan="5" style="text-align:center; padding:30px; color:var(--text-secondary); font-style:italic;">No routes added yet.</td>
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

