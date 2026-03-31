<?php
include "config/db.php";

if(isset($_POST['register'])){

    include "config.php";

    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    $emergency_contact = $_POST['emergency_contact'];
    $password = $_POST['password'];
    $role = "student";

    $sql = "INSERT INTO users 
    (name, student_id, email, address, phone, department, year, emergency_contact, password, role) 
    VALUES 
    ('$name','$student_id','$email','$address','$phone','$department','$year','$emergency_contact','$password','$role')";

    mysqli_query($conn, $sql);

    header("Location: login.php");
    
    if ($conn->query($sql)) {
        echo "<script>alert('Registered Successfully'); window.location='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include("includes/navbar.php"); ?>



<div class="container">
    <h2>Register</h2>

    <form method="POST">

    <input type="text" name="name" placeholder="Full Name" required>

    <input type="text" name="student_id" placeholder="Student ID" required>

    <input type="email" name="email" placeholder="Email" required>

    <input type="text" name="address" placeholder="Address" required>

    <input type="text" name="phone" placeholder="Phone Number" required>

    <input type="text" name="department" placeholder="Department" required>

    <select name="year" required>
        <option value="">Select Year</option>
        <option value="1st Year">1st Year</option>
        <option value="2nd Year">2nd Year</option>
        <option value="3rd Year">3rd Year</option>
        <option value="4th Year">4th Year</option>
    </select>

    <input type="text" name="emergency_contact" placeholder="Emergency Contact Number" required>

    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" name="register">Register</button>

    </form>


           <p> Already have an account? <a href="login.php">Login</a><p>

    </form>
</div>

<?php include("includes/footer_content.php"); ?>

<script src="js/theme.js"></script>
</body>
</html>
