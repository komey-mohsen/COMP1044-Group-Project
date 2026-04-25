<?php
ini_set('display_errors', 0);
include('../config/db.php');
mysqli_report(MYSQLI_REPORT_OFF);

$student_id = intval($_POST['student_id'] ?? 0);
$company    = mysqli_real_escape_string($conn, trim($_POST['company_name'] ?? ''));

$success   = false;
$error_msg = '';

if ($student_id <= 0) {
    $error_msg = "Invalid student ID.";
} elseif (strlen($company) < 3) {
    $error_msg = "Company name must be at least 3 characters.";
} else {
    // Check the student exists before inserting
    $check = mysqli_query($conn, "SELECT student_id FROM students WHERE student_id = $student_id");
    if (!$check || mysqli_num_rows($check) === 0) {
        $error_msg = "Student with ID $student_id does not exist. Please add the student first.";
    } else {
        $result = mysqli_query(
            $conn,
            "INSERT INTO internships (student_id, company_name) VALUES ($student_id, '$company')"
        );
        if ($result === false) {
            $error_msg = mysqli_error($conn);
        } else {
            $success = true;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Internship</title>
    <style>
        body {
            font-family: Arial;
            background: linear-gradient(to right, #8e9eab, #eef2f3);
        }
        .container {
            width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .success {
            color: green;
            font-size: 18px;
            margin: 20px 0;
        }
        .error {
            color: red;
            font-size: 18px;
            margin: 20px 0;
        }
        .icon {
            font-size: 50px;
            margin: 10px 0;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #4a6cf7;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }
        .back-btn:hover {
            background: #3b5bdb;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if ($success): ?>
        <div class="icon">✅</div>
        <h2>Success!</h2>
        <p class="success">Internship assigned successfully!</p>
    <?php else: ?>
        <div class="icon">❌</div>
        <h2>Error</h2>
        <p class="error"><?= htmlspecialchars($error_msg) ?></p>
    <?php endif; ?>

    <a class="back-btn" href="../../frontend/assign_internship.html">← Back</a>
</div>
</body>
</html>