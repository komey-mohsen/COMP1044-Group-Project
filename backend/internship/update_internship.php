<?php
ini_set('display_errors', 0);
include('../config/db.php');
mysqli_report(MYSQLI_REPORT_OFF);

$id          = intval($_POST['internship_id'] ?? 0);
$company     = trim($_POST['company_name']    ?? '');
$company     = mysqli_real_escape_string($conn, $company);
$assessor_raw = $_POST['assessor_id'] ?? '';

$success   = false;
$error_msg = '';

if ($id <= 0) {
    $error_msg = "Invalid internship ID.";
} elseif (strlen($company) < 3) {
    $error_msg = "Company name must be at least 3 characters.";
} else {
    // Allow NULL assessor (Unassigned)
    $assessor_sql = ($assessor_raw !== '' && intval($assessor_raw) > 0)
        ? intval($assessor_raw)
        : 'NULL';

    $query  = "UPDATE internships
               SET company_name = '$company', assessor_id = $assessor_sql
               WHERE internship_id = $id";
    $result = mysqli_query($conn, $query);

    if ($result === false) {
        $error_msg = mysqli_error($conn);
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
    <title>Update Internship</title>
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.12);
            padding: 50px 44px;
            text-align: center;
            width: 100%;
            max-width: 460px;
            margin: 20px;
        }

        .icon { font-size: 60px; margin-bottom: 14px; }

        h2 { margin: 0 0 12px; color: #111827; }

        .msg { font-size: 16px; margin-bottom: 28px; }
        .success { color: #15803d; }
        .error   { color: #dc2626; }

        .btn {
            display: inline-block;
            margin: 5px;
            padding: 10px 22px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: bold;
        }

        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
<div class="card">
    <?php if ($success): ?>
        <div class="icon">✅</div>
        <h2>Internship Updated</h2>
        <p class="msg success">Internship #<?= $id ?> has been updated successfully.</p>
        <a class="btn" href="../../frontend/manage_internships.html">&#8592; Back to List</a>
        <a class="btn" href="../../frontend/admin_dashboard.html">Dashboard</a>
    <?php else: ?>
        <div class="icon">❌</div>
        <h2>Update Failed</h2>
        <p class="msg error"><?= htmlspecialchars($error_msg) ?></p>
        <a class="btn" href="../../frontend/manage_internships.html">&#8592; Back to List</a>
        <a class="btn" href="../../frontend/admin_dashboard.html">Dashboard</a>
    <?php endif; ?>
</div>
</body>
</html>
