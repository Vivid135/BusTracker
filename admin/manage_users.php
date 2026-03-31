<?php
session_start();
include('../config/db.php');

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

if(isset($_GET['action']) && isset($_GET['user_id'])){
    $user_id = (int)$_GET['user_id'];
    $action = $_GET['action'];
    
    if($action == 'block'){
        mysqli_query($conn, "UPDATE users SET status='blocked' WHERE id=$user_id");
        header("Location: manage_users.php?msg=blocked");
        exit();
    } elseif($action == 'unblock'){
        mysqli_query($conn, "UPDATE users SET status='active' WHERE id=$user_id");
        header("Location: manage_users.php?msg=unblocked");
        exit();
    } elseif($action == 'remove'){
        mysqli_query($conn, "DELETE FROM users WHERE id=$user_id");
        header("Location: manage_users.php?msg=removed");
        exit();
    }
}

if(isset($_GET['report_action']) && isset($_GET['report_id'])){
    $report_id = (int)$_GET['report_id'];
    $report_action = $_GET['report_action'];
    
    if($report_action == 'resolve'){
        mysqli_query($conn, "UPDATE user_reports SET status='resolved' WHERE id=$report_id");
        header("Location: manage_users.php?msg=resolved");
        exit();
    } elseif($report_action == 'dismiss'){
        mysqli_query($conn, "UPDATE user_reports SET status='dismissed' WHERE id=$report_id");
        header("Location: manage_users.php?msg=dismissed");
        exit();
    }
}

$users_result = mysqli_query($conn, "SELECT id, name, email, role, status, created_at FROM users ORDER BY created_at ASC");

$reports_result = mysqli_query($conn, "SELECT r.*, u.name as reported_by_name FROM user_reports r LEFT JOIN users u ON u.id = r.reported_by WHERE r.status='pending' ORDER BY r.created_at ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/theme.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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
        
        @media (max-width: 768px) {
            .container {
                padding: 0 10px;
            }
            
            h1 {
                font-size: 24px;
                margin-bottom: 20px;
            }
            
            h2 {
                font-size: 20px;
                margin-bottom: 15px;
            }
            
            .dataTables_wrapper {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            table.dataTable {
                min-width: 600px;
                font-size: 14px;
            }
            
            table.dataTable th,
            table.dataTable td {
                padding: 8px 6px;
                white-space: nowrap;
            }
            
            table.dataTable a {
                padding: 4px 8px;
                font-size: 11px;
                margin: 1px;
                display: inline-block;
            }
            
            table.dataTable span {
                font-size: 10px;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 0 5px;
            }
            
            h1 {
                font-size: 20px;
            }
            
            h2 {
                font-size: 18px;
            }
            
            table.dataTable {
                font-size: 12px;
                min-width: 500px;
            }
            
            table.dataTable th,
            table.dataTable td {
                padding: 6px 4px;
            }
            
            table.dataTable a {
                padding: 3px 6px;
                font-size: 10px;
            }
        }
        
        .dataTables_length,
        .dataTables_filter,
        .dataTables_info,
        .dataTables_paginate {
            margin-bottom: 10px;
        }
        
        @media (max-width: 768px) {
            .dataTables_length,
            .dataTables_filter {
                width: 100%;
                margin-bottom: 15px;
            }
            
            .dataTables_length select,
            .dataTables_filter input {
                width: 100%;
            }
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
    <h1 style="text-align:center;">User Management</h1>

    
    <?php if(isset($_GET['msg'])): ?>
        <div style="background:#4CAF50; color:white; padding:12px; border-radius:6px; margin-bottom:20px; text-align:center; font-weight:bold;">
            <?php 
            $msg = $_GET['msg'];
            if($msg == 'blocked') echo "User blocked successfully";
            elseif($msg == 'unblocked') echo "User unblocked successfully";
            elseif($msg == 'removed') echo "User removed successfully";
            elseif($msg == 'resolved') echo "Report resolved successfully";
            elseif($msg == 'dismissed') echo "Report dismissed successfully";
            ?>
        </div>
    <?php endif; ?>
    
    <h2 style="text-align:center; margin-top:40px; margin-bottom:20px;">All Users</h2>
    
    <div style="overflow-x:auto;">
        <table id="usersTable" style="width:100%; border-collapse:collapse; background:var(--card-bg); border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background:linear-gradient(135deg, var(--button-bg), var(--button-hover)); color:white;">
                    <th style="padding:12px; text-align:left; font-weight:bold;">ID</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Name</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Email</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Role</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Status</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Created</th>
                    <th style="padding:12px; text-align:center; font-weight:bold;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if($users_result && mysqli_num_rows($users_result) > 0): ?>
                    <?php while($user = mysqli_fetch_assoc($users_result)): ?>
                        <tr style="border-bottom:1px solid var(--border-color); transition:background-color 0.2s;" onmouseover="this.style.backgroundColor='var(--bg-secondary)'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding:12px;"><?php echo $user['id']; ?></td>
                            <td style="padding:12px; font-weight:500;"><?php echo htmlspecialchars($user['name']); ?></td>
                            <td style="padding:12px;"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td style="padding:12px;">
                                <span style="padding:4px 8px; border-radius:4px; font-size:12px; font-weight:bold; 
                                    <?php if($user['role'] == 'admin'): ?>
                                        background:#6f42c1; color:white;
                                    <?php else: ?>
                                        background:#17a2b8; color:white;
                                    <?php endif; ?>">
                                    <?php echo ucfirst($user['role']); ?>
                                </span>
                            </td>
                            <td style="padding:12px;">
                                <span style="padding:4px 8px; border-radius:4px; font-size:12px; font-weight:bold; 
                                    <?php if($user['status'] == 'active'): ?>
                                        background:#28a745; color:white;
                                    <?php else: ?>
                                        background:#dc3545; color:white;
                                    <?php endif; ?>">
                                    <?php echo ucfirst($user['status']); ?>
                                </span>
                            </td>
                            <td style="padding:12px;"><?php echo date('M j, Y', strtotime($user['created_at'])); ?></td>
                            <td style="padding:12px; text-align:center;">
                                <?php if($user['status'] == 'active'): ?>
                                    <a href="manage_users.php?action=block&user_id=<?php echo $user['id']; ?>" 
                                       style="background:#ffc107; color:#212529; padding:4px 8px; text-decoration:none; border-radius:4px; font-size:11px; font-weight:bold; margin-right:4px; transition:background-color 0.2s;"
                                       onmouseover="this.style.backgroundColor='#e0a800'"
                                       onmouseout="this.style.backgroundColor='#ffc107'">
                                        Block
                                    </a>
                                <?php else: ?>
                                    <a href="manage_users.php?action=unblock&user_id=<?php echo $user['id']; ?>" 
                                       style="background:#28a745; color:white; padding:4px 8px; text-decoration:none; border-radius:4px; font-size:11px; font-weight:bold; margin-right:4px; transition:background-color 0.2s;"
                                       onmouseover="this.style.backgroundColor='#218838'"
                                       onmouseout="this.style.backgroundColor='#28a745'">
                                        Unblock
                                    </a>
                                <?php endif; ?>
                                <a href="manage_users.php?action=remove&user_id=<?php echo $user['id']; ?>" 
                                   onclick="return confirm('Remove this user permanently?');" 
                                   style="background:#dc3545; color:white; padding:4px 8px; text-decoration:none; border-radius:4px; font-size:11px; font-weight:bold; transition:background-color 0.2s;"
                                   onmouseover="this.style.backgroundColor='#c82333'"
                                   onmouseout="this.style.backgroundColor='#dc3545'">
                                    Remove
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="padding:20px; text-align:center; color:var(--text-secondary);">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'asc']],
            ordering: false,
            language: {
                search: "Search users...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ users",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });
    });
    </script>
    
    <h2 style="text-align:center; margin-top:40px; margin-bottom:20px;">User Reports</h2>
    
    <div style="overflow-x:auto;">
        <table id="reportsTable" style="width:100%; border-collapse:collapse; background:var(--card-bg); border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background:linear-gradient(135deg, var(--button-bg), var(--button-hover)); color:white;">
                    <th style="padding:12px; text-align:left; font-weight:bold;">ID</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Reported By</th>
                    
                    <th style="padding:12px; text-align:left; font-weight:bold;">Reason</th>
                    <th style="padding:12px; text-align:left; font-weight:bold;">Date</th>
                    <th style="padding:12px; text-align:center; font-weight:bold;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if($reports_result && mysqli_num_rows($reports_result) > 0): ?>
                    <?php while($report = mysqli_fetch_assoc($reports_result)): ?>
                        <tr style="border-bottom:1px solid var(--border-color); transition:background-color 0.2s;" onmouseover="this.style.backgroundColor='var(--bg-secondary)'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding:12px;"><?php echo $report['id']; ?></td>
                            <td style="padding:12px; font-weight:500;"><?php echo htmlspecialchars($report['reported_by_name'] ?: 'Unknown'); ?></td>
                            
                            <td style="padding:12px; max-width:200px; word-wrap:break-word;"><?php echo htmlspecialchars($report['reason']); ?></td>
                            <td style="padding:12px;"><?php echo date('M j, Y h:i A', strtotime($report['created_at'])); ?></td>
                            <td style="padding:12px; text-align:center;">
                                <a href="manage_users.php?report_action=resolve&report_id=<?php echo $report['id']; ?>" 
                                   onclick="return confirm('Mark this report as resolved?');" 
                                   style="background:#28a745; color:white; padding:4px 8px; text-decoration:none; border-radius:4px; font-size:11px; font-weight:bold; margin-right:4px; transition:background-color 0.2s;"
                                   onmouseover="this.style.backgroundColor='#218838'"
                                   onmouseout="this.style.backgroundColor='#28a745'">
                                    Resolve
                                </a>
                                <a href="manage_users.php?report_action=dismiss&report_id=<?php echo $report['id']; ?>" 
                                   onclick="return confirm('Dismiss this report?');" 
                                   style="background:#6c757d; color:white; padding:4px 8px; text-decoration:none; border-radius:4px; font-size:11px; font-weight:bold; transition:background-color 0.2s;"
                                   onmouseover="this.style.backgroundColor='#5a6268'"
                                   onmouseout="this.style.backgroundColor='#6c757d'">
                                    Dismiss
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center; padding:30px; color:var(--text-secondary); font-style:italic;">No pending reports found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <script>
    $(document).ready(function() {
        <?php if($reports_result && mysqli_num_rows($reports_result) > 0): ?>
        $('#reportsTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[0, 'asc']],
            ordering: false,
            language: {
                search: "Search reports...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ reports",
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
