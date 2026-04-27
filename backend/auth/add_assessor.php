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

        .detail {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 16px;
            color: #166534;
            margin-bottom: 28px;
            text-align: left;
        }

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
