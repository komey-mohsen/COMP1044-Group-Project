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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 16px;
            padding: 52px 48px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 8px 24px rgba(0,0,0,0.07);
            text-align: center;
            margin: 24px;
        }
        .icon { font-size: 64px; margin-bottom: 18px; }
        h2 { margin: 0 0 16px; color: #0f172a; font-size: 28px; font-weight: 700; }
        .success { color: #16a34a; font-size: 16px; margin-bottom: 32px; }
        .error   { color: #dc2626; font-size: 16px; margin-bottom: 32px; }
        .back-btn {
            display: inline-block;
            margin: 6px;
            padding: 12px 28px;
            background: #2563eb;
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .back-btn:hover { background: #1d4ed8; }
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