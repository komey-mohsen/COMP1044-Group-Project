<?php
ini_set('display_errors', 0);
include('../config/db.php');
mysqli_report(MYSQLI_REPORT_OFF);

$username  = trim($_POST['username'] ?? '');
$password  = $_POST['password']      ?? '';
$success   = false;
$error_msg = '';
$new_id    = null;

if (strlen($username) < 4) {
    $error_msg = "Username must be at least 4 characters.";
} elseif (strlen($password) < 6) {
    $error_msg = "Password must be at least 6 characters.";
} else {
    $u_esc = mysqli_real_escape_string($conn, $username);
    $p_esc = mysqli_real_escape_string($conn, $password);

    // Reject duplicate usernames
    $check = mysqli_query($conn, "SELECT user_id FROM users WHERE username = '$u_esc'");
    if ($check && mysqli_num_rows($check) > 0) {
        $error_msg = "Username &ldquo;$u_esc&rdquo; already exists. Choose a different one.";
    } else {
        $result = mysqli_query(
            $conn,
            "INSERT INTO users (username, password, role) VALUES ('$u_esc', '$p_esc', 'assessor')"
        );

        if ($result === false) {
            $error_msg = mysqli_error($conn);
        } else {
            $success = true;
            $new_id  = mysqli_insert_id($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Assessor</title>
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

        .detail {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            color: #166534;
            margin-bottom: 24px;
            text-align: left;
        }

        .detail.err-detail {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }

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
        <h2>Assessor Added</h2>
        <p class="msg success">The new assessor account has been created.</p>
        <div class="detail">
            <strong>Username:</strong> <?= htmlspecialchars($username) ?><br>
            <strong>User ID:</strong> <?= $new_id ?>
        </div>
        <a class="btn" href="../../frontend/manage_assessors.html">&#8592; Back to List</a>
        <a class="btn" href="../../frontend/admin_dashboard.html">Dashboard</a>
    <?php else: ?>
        <div class="icon">❌</div>
        <h2>Could Not Add Assessor</h2>
        <p class="msg error"><?= $error_msg ?></p>
        <a class="btn" href="../../frontend/manage_assessors.html">&#8592; Try Again</a>
        <a class="btn" href="../../frontend/admin_dashboard.html">Dashboard</a>
    <?php endif; ?>
</div>
</body>
</html>
