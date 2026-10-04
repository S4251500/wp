<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') {

    // Localhost
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "bookverse";

} else {

    // Jacob 5 / Coreteaching
    $host = "talsprddb02.int.its.rmit.edu.au";
    $username = "S4251500";
    $password = "oLJwnQ_!hQB8kqav8M";
    $database = "S4251500_159009";
}

// MySQLi procedural connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set character encoding
mysqli_set_charset($conn, "utf8mb4");
?>