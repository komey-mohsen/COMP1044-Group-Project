<?php
ini_set('display_errors', 0);
include('../config/db.php');
mysqli_report(MYSQLI_REPORT_OFF);

// All internships joined with student name and assessor username
$query = "
    SELECT  i.internship_id,
            i.student_id,
            s.name                              AS student_name,
            i.company_name,
            i.assessor_id,
            COALESCE(u.username, 'Unassigned')  AS assessor_name
    FROM  internships i
    JOIN  students   s ON s.student_id = i.student_id
    LEFT JOIN users  u ON u.user_id    = i.assessor_id
    ORDER BY i.internship_id ASC
";

$result      = mysqli_query($conn, $query);
$internships = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $internships[] = $row;
    }
}

// Assessors list for the edit dropdown
$aResult   = mysqli_query($conn, "SELECT user_id, username FROM users WHERE role = 'assessor' ORDER BY username");
$assessors = [];
if ($aResult) {
    while ($row = mysqli_fetch_assoc($aResult)) {
        $assessors[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode(['internships' => $internships, 'assessors' => $assessors]);
