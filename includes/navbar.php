<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}
?>

<style>
.navbar {
    background: var(--navbar-bg);
    padding: 15px 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
}

.logo {
    display: flex;
    align-items: center;
    color: var(--navbar-text);
    text-decoration: none;
    font-weight: bold;
    font-size: 20px;
}

.nav-links {
    display: flex;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-links li {
    margin-left: 25px;
}

.nav-links a {
    color: var(--navbar-text);
    text-decoration: none;
    padding: 8px 18px;
    border-radius: 5px;
    font-weight: bold;
    transition: 0.3s;
}

.nav-links a:hover {
    background: var(--navbar-link-active);
}

.theme-toggle {
    background: none;
    border: 2px solid var(--navbar-text);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    margin-left: 20px;
}

.theme-toggle:hover {
    background: var(--navbar-link-hover);
    border-color: var(--navbar-link-hover);
}

.theme-toggle svg {
    width: 20px;
    height: 20px;
    fill: var(--navbar-text);
}

body {
    padding-top: 80px;
}
</style>

<nav class="navbar">
    <div class="logo">
        <?php
        $logo_paths = [
            'includes/adbu_app_logo_512x512.png',
            '../includes/adbu_app_logo_512x512.png',
            '/BusTracker/includes/adbu_app_logo_512x512.png'
        ];
        
        $logo_src = '';
        foreach ($logo_paths as $path) {
            if (file_exists($path)) {
                $logo_src = $path;
                break;
            }
        }
        
        if ($logo_src) {
            echo '<img src="' . $logo_src . '" alt="ADBU Logo" style="height:30px; vertical-align:middle; margin-right:10px;">';
        } else {
            echo '<span style="font-size:24px; font-weight:bold; margin-right:10px;">🎓</span>';
        }
        ?>
        ADBU Bus Tracker
    </div>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        
        <?php
        if(isset($_SESSION['user_id'])) {
            if($_SESSION['role'] == 'admin'){
                echo '<li><a href="admin/dashboard.php">Dashboard</a></li>';
            } else {
                echo '<li><a href="student/dashboard.php">Dashboard</a></li>';
            }
            echo '<li><a href="logout.php">Logout</a></li>';
        } else {
            echo '<li><a href="login.php">Login</a></li>';
            echo '<li><a href="register.php">Register</a></li>';
        }
        ?>
        
        <li><a href="contact.php">Contact</a></li>
        <li><button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
            <svg class="sun-icon" viewBox="0 0 24 24" style="display: none;">
                <path d="M12 17.5C9.5 17.5 7.5 15.5 7.5 13S9.5 8.5 12 8.5 16.5 10.5 16.5 13 14.5 17.5 12 17.5M12 7C8.7 7 6 9.7 6 13S8.7 19 12 19 18 16.3 18 13 15.3 7 12 7M12 2L14.4 6.4L19 5.7L16.2 9.8L18.6 14L14 12.3L9.4 14L11.8 9.8L9 5.7L13.6 6.4L12 2Z"/>
            </svg>
            <svg class="moon-icon" viewBox="0 0 24 24">
                <path d="M17.75,4.09L15.22,6.03L16.13,9.09L13.5,7.28L10.87,9.09L11.78,6.03L9.25,4.09L12.44,4L13.5,1L14.56,4L17.75,4.09M21.25,11L19.61,12.25L20.2,14.23L18.5,13.06L16.8,14.23L17.39,12.25L15.75,11L17.81,10.95L18.5,9L19.19,10.95L21.25,11M18.97,15.95C19.8,15.87 20.69,17.05 20.16,17.8C19.84,18.25 19.5,18.67 19.08,19.07C15.17,23 8.84,23 4.94,19.07C1.03,15.17 1.03,8.83 4.94,4.93C5.34,4.53 5.76,4.17 6.21,3.85C6.96,3.32 8.14,4.21 8.06,5.04C7.79,7.9 8.75,10.87 10.95,13.06C13.14,15.26 16.1,16.22 18.97,15.95M17.33,17.97C14.5,17.81 11.7,16.64 9.53,14.5C7.36,12.31 6.2,9.5 6.04,6.68C3.23,9.82 3.34,14.64 6.35,17.66C9.37,20.67 14.19,20.78 17.33,17.97Z"/>
            </svg>
        </button>
    </ul>
</nav>
