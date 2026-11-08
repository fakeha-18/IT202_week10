<?php
$host = "sql1.njit.edu";
$username = "fi53";
$password = "T;7FW%*#dzU*p_gB17-P";
$database = "fi53";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed.");
}
?>