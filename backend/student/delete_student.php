<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

include('../config/db.php');

$id        = intval($_POST['student_id'] ?? 0);
$success   = false;
$error_msg = '';

if ($id <= 0) {
    $error_msg = "Invalid student ID.";
} else {
    // Disable strict exception throwing so we can handle errors ourselves
    mysqli_report(MYSQLI_REPORT_OFF);

    $query = "DELETE FROM students WHERE student_id=$id";
    $result = mysqli_query($conn, $query);

    if ($result === false) {
        $error_msg = mysqli_error($conn);
        // Friendly message for foreign key constraint violations
        if (str_contains($error_msg, 'foreign key constraint')) {
            $error_msg = "Cannot delete student ID $id because they have linked internship records. Remove those first.";
        }
    } elseif (mysqli_affected_rows($conn) === 0) {
        $error_msg = "No student found with ID $id.";
    } else {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1f4e79, #4e73df);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 100%;
            max-width: 460px;
            background: white;
            border-radius: 20px;
            padding: 50px 44px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.28);
            text-align: center;
            margin: 20px;
        }

        .icon { font-size: 64px; margin-bottom: 16px; }

        h2 { margin: 0 0 14px; color: #111827; font-size: 28px; }

        .message { font-size: 16px; margin-bottom: 28px; }
        .success-msg { color: #15803d; }
        .error-msg   { color: #dc2626; }

        .btn {
            display: inline-block;
            margin: 6px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #4e73df, #1f4e79);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            transition: opacity 0.15s;
        }

        .btn:hover { opacity: 0.9; }
    </style>
</head>
<body>
<div class="card">
    <?php if ($success): ?>
        <div class="icon">✅</div>
        <h2>Student Deleted!</h2>
        <p class="message success-msg">Student ID <?= $id ?> has been removed from the system.</p>
        <a class="btn" href="../../frontend/delete_student.html">Delete Another</a>
        <a class="btn" href="../../frontend/admin_dashboard.html">Dashboard</a>
    <?php else: ?>
        <div class="icon">❌</div>
        <h2>Deletion Failed</h2>
        <p class="message error-msg"><?= htmlspecialchars($error_msg) ?></p>
        <a class="btn" href="../../frontend/delete_student.html">&#8592; Try Again</a>
        <a class="btn" href="../../frontend/admin_dashboard.html">Dashboard</a>
    <?php endif; ?>
</div>
</body>
</html>
