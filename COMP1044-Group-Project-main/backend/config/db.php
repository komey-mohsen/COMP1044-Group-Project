<?php
$conn = mysqli_connect("localhost", "root", "root", "internship_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>