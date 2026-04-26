<?php
include('../config/db.php');

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    if ($user['role'] == 'admin') {
        header("Location: ../../frontend/admin_dashboard.html");
    } else {
        header("Location: ../../frontend/assessor_dashboard.html");
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Failed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #1c3d5a, #2e6da4);
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            width: 380px;
        }
        .icon {
            font-size: 60px;
            margin-bottom: 10px;
        }
        h2 {
            color: #dc2626;
            margin-bottom: 10px;
        }
        p {
            color: #6b7280;
            margin-bottom: 25px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(to right, #1c3d5a, #2e6da4);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">❌</div>
        <h2>Login Failed</h2>
        <p>Invalid username or password.<br>Please try again.</p>
        <a href="../../frontend/index.html" class="btn">← Back to Login</a>
    </div>
</body>
</html>
<?php } ?>