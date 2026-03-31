<?php
include('../config/db.php');

$column_check = mysqli_query($conn, "SHOW COLUMNS FROM buses LIKE 'seat_capacity'");
if(mysqli_num_rows($column_check) == 0) {
    mysqli_query($conn, "ALTER TABLE buses ADD COLUMN seat_capacity INT DEFAULT 50");
}

$status_check = mysqli_query($conn, "SHOW COLUMNS FROM buses LIKE 'status'");
if(mysqli_num_rows($status_check) == 0) {
    mysqli_query($conn, "ALTER TABLE buses ADD COLUMN status VARCHAR(20) DEFAULT 'active'");
}

if(isset($_GET['delete_id'])){
    $delete_id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM buses WHERE id=$delete_id");
    header("Location: add_bus.php");
    exit();
}

$edit_bus = null;
if(isset($_GET['edit_id'])){
    $edit_id = (int)$_GET['edit_id'];
    $result = mysqli_query($conn, "SELECT * FROM buses WHERE id=$edit_id");
    $edit_bus = mysqli_fetch_assoc($result);
}

if(isset($_POST['add'])){
    $bus_number = $_POST['bus_number'];
    $seat_capacity = $_POST['seat_capacity'];
    $status = $_POST['status'];

    mysqli_query($conn,"INSERT INTO buses (bus_number, seat_capacity, status) 
    VALUES ('$bus_number', $seat_capacity, '$status')");

    header("Location: add_bus.php?success=1");
    exit();
}

if(isset($_POST['update'])){
    $bus_id = (int)$_POST['bus_id'];
    $bus_number = $_POST['bus_number'];
    $seat_capacity = $_POST['seat_capacity'];
    $status = $_POST['status'];

    mysqli_query($conn,"UPDATE buses SET bus_number='$bus_number', seat_capacity=$seat_capacity, status='$status' WHERE id=$bus_id");

    header("Location: add_bus.php?success=2");
    exit();
}

$buses_result = mysqli_query($conn, "SELECT b.id, b.bus_number, b.status, b.seat_capacity FROM buses b ORDER BY b.id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Bus</title>
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
    <h1 style="text-align:center;"><?php echo $edit_bus ? 'Edit Bus' : 'Add Bus'; ?></h1>
    
    <?php if(isset($_GET['success'])): ?>
        <div style="background:#28a745; color:white; padding:12px; border-radius:6px; margin-bottom:20px; text-align:center; font-weight:bold;">
            <?php 
            if($_GET['success'] == '1') echo "Bus added successfully!";
            elseif($_GET['success'] == '2') echo "Bus updated successfully!";
            ?>
        </div>
    <?php endif; ?>

    <div style="max-width:600px; margin:0 auto; background:var(--card-bg); border:1px solid var(--border-color); border-radius:12px; padding:30px; margin-bottom:30px;">
        <form method="POST" style="display:flex; flex-direction:column; gap:20px;">
            <?php if($edit_bus): ?>
                <input type="hidden" name="bus_id" value="<?php echo $edit_bus['id']; ?>">
            <?php endif; ?>
            
            <div>
                <label style="font-weight:bold; margin-bottom:5px; display:block;">Bus Number:</label>
                <input type="text" name="bus_number" required value="<?php echo $edit_bus ? htmlspecialchars($edit_bus['bus_number']) : ''; ?>" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; background:var(--card-bg); color:var(--text-primary);">
            </div>

            <div>
                <label style="font-weight:bold; margin-bottom:5px; display:block;">Seat Capacity:</label>
                <input type="number" name="seat_capacity" min="1" max="100" required value="<?php echo $edit_bus ? $edit_bus['seat_capacity'] : ''; ?>" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; background:var(--card-bg); color:var(--text-primary);">
            </div>

            <div>
                <label style="font-weight:bold; margin-bottom:5px; display:block;">Status:</label>
                <select name="status" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; background:var(--card-bg); color:var(--text-primary);">
                    <option value="active" <?php echo ($edit_bus && $edit_bus['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo ($edit_bus && $edit_bus['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>

            <div style="text-align:center;">
                <button name="<?php echo $edit_bus ? 'update' : 'add'; ?>" style="background:var(--button-bg); color:var(--button-text); padding:12px 24px; border:none; border-radius:6px; font-weight:bold; cursor:pointer;">
                    <?php echo $edit_bus ? 'Update Bus' : 'Add Bus'; ?>
                </button>
                <?php if($edit_bus): ?>
                    <a href="add_bus.php" style="margin-left:10px; background:#6c757d; color:white; padding:12px 24px; text-decoration:none; border-radius:6px; font-weight:bold; display:inline-block;">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <br>

    <h2 style="text-align:center; margin-top:40px; margin-bottom:20px;">All Buses</h2>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; background:var(--card-bg); border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background:linear-gradient(135deg, var(--button-bg), var(--button-hover)); color:white;">
                    <th style="padding:12px; text-align:left; font-weight:bold;">ID</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Bus Number</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Seat Capacity</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Status</th>
                    <th style="padding:12px; text-align:center; font-weight:bold;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($buses_result && mysqli_num_rows($buses_result) > 0): ?>
                    <?php while($bus = mysqli_fetch_assoc($buses_result)): ?>
                        <tr style="border-bottom:1px solid var(--border-color); transition:background-color 0.2s;" onmouseover="this.style.backgroundColor='var(--bg-secondary)'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding:12px;"><?php echo $bus['id']; ?></td>
                            <td style="padding:12px; font-weight:500;"><?php echo $bus['bus_number']; ?></td>
                            <td style="padding:12px;"><?php echo $bus['seat_capacity']; ?> seats</td>
                            <td style="padding:12px;">
                                <span style="padding:4px 8px; border-radius:4px; font-size:12px; font-weight:bold; 
                                    <?php if($bus['status'] == 'active'): ?>
                                        background:#28a745; color:white;
                                    <?php else: ?>
                                        background:#dc3545; color:white;
                                    <?php endif; ?>">
                                    <?php echo ucfirst($bus['status']); ?>
                                </span>
                            </td>
                            <td style="padding:12px; text-align:center;">
                                <a href="add_bus.php?edit_id=<?php echo $bus['id']; ?>" 
                                   style="background:#007bff; color:white; padding:6px 12px; text-decoration:none; border-radius:4px; font-size:12px; font-weight:bold; margin-right:4px; transition:background-color 0.2s;"
                                   onmouseover="this.style.backgroundColor='#0056b3'"
                                   onmouseout="this.style.backgroundColor='#007bff'">
                                    Edit
                                </a>
                                <a href="add_bus.php?delete_id=<?php echo $bus['id']; ?>" 
                                   onclick="return confirm('Delete this bus?');" 
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
                        <td colspan="5" style="text-align:center; padding:30px; color:var(--text-secondary); font-style:italic;">No buses added yet.</td>
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

