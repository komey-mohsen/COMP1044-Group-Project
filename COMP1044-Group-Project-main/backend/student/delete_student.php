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
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
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

        .message { font-size: 16px; margin-bottom: 32px; }
        .success-msg { color: #16a34a; }
        .error-msg   { color: #dc2626; }

        .btn {
            display: inline-block;
            margin: 6px;
            padding: 12px 28px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn:hover { background: #1d4ed8; }
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
