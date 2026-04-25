<?php
$conn = new mysqli("localhost", "root", "root", "internship_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_POST['student_id'];

$sql = "
SELECT s.name, i.company_name, a.total
FROM students s
JOIN internships i ON s.student_id = i.student_id
JOIN assessments a ON i.internship_id = a.internship_id
WHERE s.student_id = '$student_id'
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Results</title>
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
        .result-box {
            background: #f5f7ff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            text-align: left;
        }
        .result-box p {
            margin: 10px 0;
            font-size: 16px;
        }
        .score {
            font-size: 28px;
            font-weight: bold;
            color: #4a6cf7;
            text-align: center;
            margin-top: 15px;
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
        .error {
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Student Results</h2>

    <?php if ($result->num_rows > 0):
        $row = $result->fetch_assoc(); ?>
        <div class="result-box">
            <p><strong>Name:</strong> <?= $row['name'] ?></p>
            <p><strong>Company:</strong> <?= $row['company_name'] ?></p>
        </div>
        <div class="score">
            Final Score: <?= $row['total'] ?> / 100
        </div>
    <?php else: ?>
        <p class="error">No results found for this student ID.</p>
    <?php endif; ?>

    <a class="back-btn" href="../../frontend/results.html">← Back</a>
</div>
</body>
</html>

<?php $conn->close(); ?>