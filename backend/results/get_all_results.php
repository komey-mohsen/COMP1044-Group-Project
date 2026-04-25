<?php
ini_set('display_errors', 0);
include('../config/db.php');
mysqli_report(MYSQLI_REPORT_OFF);

$result = mysqli_query($conn,
    "SELECT  s.student_id,
             s.name         AS student_name,
             i.company_name,
             a.total        AS final_score
     FROM    students    s
     JOIN    internships i ON i.student_id    = s.student_id
     JOIN    assessments a ON a.internship_id = i.internship_id
     ORDER   BY s.name ASC"
);

$rows = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($rows);
