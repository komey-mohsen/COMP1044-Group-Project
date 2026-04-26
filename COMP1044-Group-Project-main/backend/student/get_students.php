<?php
ini_set('display_errors', 0);
include('../config/db.php');
mysqli_report(MYSQLI_REPORT_OFF);

$result = mysqli_query($conn, "
    SELECT  s.student_id,
            s.name,
            s.programme,
            COALESCE(i.company_name, 'Not assigned') AS company_name,
            COALESCE(u.username, 'Not assigned') AS assessor_name,
            CASE WHEN a.assessment_id IS NULL THEN 'Pending' ELSE 'Completed' END AS assessment_status,
            a.total AS final_score
    FROM    students s
    LEFT JOIN internships i ON i.student_id = s.student_id
    LEFT JOIN users u ON u.user_id = i.assessor_id
    LEFT JOIN assessments a ON a.internship_id = i.internship_id
    ORDER BY s.name ASC
");

$rows = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($rows);
?>
