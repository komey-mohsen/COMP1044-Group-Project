<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('../config/db.php');

$id = $_POST['student_id'];
$name = $_POST['student_name'];
$programme = $_POST['programme'];

$query = "INSERT INTO students (student_id, name, programme)
          VALUES ('$id', '$name', '$programme')";

$success = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 400px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .icon { font-size: 50px; margin: 10px 0; }
        .success { color: green; font-size: 18px; margin: 15px 0; }
        .error { color: red; font-size: 16px; margin: 15px 0; }
        .back-btn {
            display: inline-block;
            margin: 10px 5px 0;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .back-btn:hover { background: #0056b3; }
    </style>
</head>
<body>
<div class="container">
    <?php if ($success): ?>
        <div class="icon">✅</div>
        <h2>Success!</h2>
        <p class="success">Student added successfully!</p>
        <a class="back-btn" href="../../frontend/add_student.html">Add Another</a>
        <a class="back-btn" href="../../frontend/admin_dashboard.html">Dashboard</a>
    <?php else: ?>
        <div class="icon">❌</div>
        <h2>Error</h2>
        <p class="error"><?= mysqli_error($conn) ?></p>
        <a class="back-btn" href="../../frontend/add_student.html">← Try Again</a>
    <?php endif; ?>
</div>
</body>
</html>