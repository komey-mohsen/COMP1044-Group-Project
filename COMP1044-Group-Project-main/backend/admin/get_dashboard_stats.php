<?php
ini_set('display_errors', 0);
include('../config/db.php');
mysqli_report(MYSQLI_REPORT_OFF);

header('Content-Type: application/json');

$stats = [
    'students' => 0,
    'internships' => 0,
    'assessors' => 0,
    'assessments' => 0,
    'average_score' => null,
    'pending_assessments' => 0
];

$queries = [
    'students' => "SELECT COUNT(*) AS value FROM students",
    'internships' => "SELECT COUNT(*) AS value FROM internships",
    'assessors' => "SELECT COUNT(*) AS value FROM users WHERE role = 'assessor'",
    'assessments' => "SELECT COUNT(*) AS value FROM assessments",
    'average_score' => "SELECT AVG(total) AS value FROM assessments",
    'pending_assessments' => "
        SELECT COUNT(*) AS value
        FROM internships i
        LEFT JOIN assessments a ON a.internship_id = i.internship_id
        WHERE a.assessment_id IS NULL
    "
];

foreach ($queries as $key => $sql) {
    $result = mysqli_query($conn, $sql);
    if ($result && ($row = mysqli_fetch_assoc($result))) {
        $stats[$key] = $row['value'] === null ? null : (float) $row['value'];
    }
}

echo json_encode($stats);
?>
