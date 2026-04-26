<?php
ini_set('display_errors', 0);
include('../config/db.php');
mysqli_report(MYSQLI_REPORT_OFF);

header('Content-Type: application/json');

function fetch_rows($conn, $sql) {
    $rows = [];
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

$score_distribution = [
    'excellent' => 0,
    'good' => 0,
    'pass' => 0,
    'at_risk' => 0
];

$dist_rows = fetch_rows($conn, "
    SELECT
        SUM(CASE WHEN total >= 80 THEN 1 ELSE 0 END) AS excellent,
        SUM(CASE WHEN total >= 65 AND total < 80 THEN 1 ELSE 0 END) AS good,
        SUM(CASE WHEN total >= 50 AND total < 65 THEN 1 ELSE 0 END) AS pass,
        SUM(CASE WHEN total < 50 THEN 1 ELSE 0 END) AS at_risk
    FROM assessments
");

if (!empty($dist_rows)) {
    foreach ($score_distribution as $key => $value) {
        $score_distribution[$key] = (int) ($dist_rows[0][$key] ?? 0);
    }
}

$payload = [
    'score_distribution' => $score_distribution,
    'programme_averages' => fetch_rows($conn, "
        SELECT s.programme, COUNT(a.assessment_id) AS assessed_count, ROUND(AVG(a.total), 2) AS average_score
        FROM students s
        JOIN internships i ON i.student_id = s.student_id
        JOIN assessments a ON a.internship_id = i.internship_id
        GROUP BY s.programme
        ORDER BY average_score DESC, s.programme ASC
    "),
    'assessor_workload' => fetch_rows($conn, "
        SELECT u.username,
               COUNT(i.internship_id) AS assigned_count,
               COUNT(a.assessment_id) AS completed_count,
               ROUND(AVG(a.total), 2) AS average_score
        FROM users u
        LEFT JOIN internships i ON i.assessor_id = u.user_id
        LEFT JOIN assessments a ON a.internship_id = i.internship_id
        WHERE u.role = 'assessor'
        GROUP BY u.user_id, u.username
        ORDER BY assigned_count DESC, u.username ASC
    "),
    'pending_assessments' => fetch_rows($conn, "
        SELECT i.internship_id,
               s.student_id,
               s.name AS student_name,
               i.company_name,
               COALESCE(u.username, 'Unassigned') AS assessor_name
        FROM internships i
        JOIN students s ON s.student_id = i.student_id
        LEFT JOIN users u ON u.user_id = i.assessor_id
        LEFT JOIN assessments a ON a.internship_id = i.internship_id
        WHERE a.assessment_id IS NULL
        ORDER BY s.name ASC
    "),
    'company_counts' => fetch_rows($conn, "
        SELECT company_name, COUNT(*) AS internship_count
        FROM internships
        GROUP BY company_name
        ORDER BY internship_count DESC, company_name ASC
        LIMIT 8
    "),
    'recent_assessments' => fetch_rows($conn, "
        SELECT s.student_id,
               s.name AS student_name,
               i.company_name,
               ROUND(a.total, 2) AS final_score
        FROM assessments a
        JOIN internships i ON i.internship_id = a.internship_id
        JOIN students s ON s.student_id = i.student_id
        ORDER BY a.assessment_id DESC
        LIMIT 8
    ")
];

echo json_encode($payload);
?>
