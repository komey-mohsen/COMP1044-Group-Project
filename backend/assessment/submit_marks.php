<?php
ini_set('display_errors', 0);
include('../config/db.php');
mysqli_report(MYSQLI_REPORT_OFF);

$internship_id        = intval($_POST['internship_id']);
$undertaking_tasks    = floatval($_POST['undertaking_tasks']);
$health_safety        = floatval($_POST['health_safety']);
$theoretical_knowledge = floatval($_POST['theoretical_knowledge']);
$written_report       = floatval($_POST['written_report']);
$language_illustration = floatval($_POST['language_illustration']);
$lifelong_learning    = floatval($_POST['lifelong_learning']);
$project_management   = floatval($_POST['project_management']);
$time_management      = floatval($_POST['time_management']);
$comments             = mysqli_real_escape_string($conn, $_POST['comments']);

// Weightages: Task 10%, Safety 10%, Theory 10%, Report 15%,
//             Language 10%, Lifelong 15%, Project 15%, Time 15%
$total_score =
    ($undertaking_tasks     * 0.10) +
    ($health_safety         * 0.10) +
    ($theoretical_knowledge * 0.10) +
    ($written_report        * 0.15) +
    ($language_illustration * 0.10) +
    ($lifelong_learning     * 0.15) +
    ($project_management    * 0.15) +
    ($time_management       * 0.15);

// Column names match schema: task, safety, theory, report, language,
//                            lifelong, project, time, total, comments
$query = "INSERT INTO assessments
            (internship_id, task, safety, theory, report, language,
             lifelong, project, time, total, comments)
          VALUES
            ('$internship_id',
             '$undertaking_tasks', '$health_safety', '$theoretical_knowledge',
             '$written_report', '$language_illustration', '$lifelong_learning',
             '$project_management', '$time_management',
             '$total_score', '$comments')";

$success    = mysqli_query($conn, $query);
$error_msg  = mysqli_error($conn);
$score_fmt  = number_format($total_score, 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Result</title>
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

        .message { font-size: 16px; margin-bottom: 14px; }
        .success-msg { color: #16a34a; }
        .error-msg   { color: #dc2626; }

        .score-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            padding: 20px 28px;
            margin: 18px 0 32px;
            color: #1e40af;
        }

        .score-box .score-label {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .score-box .score-value {
            font-size: 42px;
            font-weight: 700;
            color: #1e3a5f;
        }

        .score-box .score-unit {
            font-size: 18px;
            color: #2563eb;
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
        <h2>Assessment Submitted!</h2>
        <p class="message success-msg">The assessment has been recorded successfully.</p>
        <div class="score-box">
            <div class="score-label">Final Weighted Score</div>
            <div class="score-value"><?= $score_fmt ?><span class="score-unit"> / 100</span></div>
        </div>
        <a class="btn" href="../../frontend/assessment.html">New Assessment</a>
        <a class="btn" href="../../frontend/assessor_dashboard.html">Dashboard</a>
    <?php else: ?>
        <div class="icon">❌</div>
        <h2>Submission Failed</h2>
        <p class="message error-msg"><?= htmlspecialchars($error_msg) ?></p>
        <a class="btn" href="../../frontend/assessment.html">← Try Again</a>
    <?php endif; ?>
</div>
</body>
</html>
