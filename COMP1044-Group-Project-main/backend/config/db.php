<?php
$conn = mysqli_connect("localhost", "root", "", "internship_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>