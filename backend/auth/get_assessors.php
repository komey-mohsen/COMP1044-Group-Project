<?php
ini_set('display_errors', 0);
include('../config/db.php');
mysqli_report(MYSQLI_REPORT_OFF);

$result = mysqli_query(
    $conn,
    "SELECT user_id, username, role
     FROM   users
     WHERE  role = 'assessor'
     ORDER  BY username ASC"
);

$rows = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($rows);
