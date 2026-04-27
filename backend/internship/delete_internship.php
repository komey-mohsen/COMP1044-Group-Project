<?php
ini_set('display_errors', 0);
include('../config/db.php');
mysqli_report(MYSQLI_REPORT_OFF);

$id        = intval($_POST['internship_id'] ?? 0);
$success   = false;
$error_msg = '';

if ($id <= 0) {
    $error_msg = "Invalid internship ID.";
} else {
    // Remove linked assessments first to avoid FK constraint failure
    mysqli_query($conn, "DELETE FROM assessments WHERE internship_id = $id");

    $result = mysqli_query($conn, "DELETE FROM internships WHERE internship_id = $id");

    if ($result === false) {
        $error_msg = mysqli_error($conn);
    } elseif (mysqli_affected_rows($conn) === 0) {
        $error_msg = "No internship found with ID $id.";
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
    <title>Delete Internship</title>
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
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 8px 24px rgba(0,0,0,0.07);
            padding: 52px 48px;
            text-align: center;
            width: 100%;
            max-width: 480px;
            margin: 24px;
        }

        .icon { font-size: 64px; margin-bottom: 18px; }

        h2 { margin: 0 0 16px; color: #0f172a; font-size: 28px; font-weight: 700; }

        .msg { font-size: 16px; margin-bottom: 32px; }
        .success { color: #16a34a; }
        .error   { color: #dc2626; }

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
        <h2>Internship Deleted</h2>
        <p class="msg success">Internship #<?= $id ?> and its assessments have been removed.</p>
        <a class="btn" href="../../frontend/manage_internships.html">&#8592; Back to List</a>
        <a class="btn" href="../../frontend/admin_dashboard.html">Dashboard</a>
    <?php else: ?>
        <div class="icon">❌</div>
        <h2>Deletion Failed</h2>
        <p class="msg error"><?= htmlspecialchars($error_msg) ?></p>
        <a class="btn" href="../../frontend/manage_internships.html">&#8592; Back to List</a>
        <a class="btn" href="../../frontend/admin_dashboard.html">Dashboard</a>
    <?php endif; ?>
</div>
</body>
</html>
