<?php
ini_set('display_errors', 0);
include('../config/db.php');
mysqli_report(MYSQLI_REPORT_OFF);

$result = mysqli_query($conn,
    "SELECT i.internship_id, s.name AS student_name, i.company_name
     FROM   internships i
     JOIN   students   s ON s.student_id = i.student_id
     ORDER  BY s.name ASC"
);

$rows = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($rows);
