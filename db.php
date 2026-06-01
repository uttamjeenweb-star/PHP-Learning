<?php

$host = "localhost";
$user = "root";
$password = "password";
$db_name = "php_schema";
$port = 3306;

// DB_HOST=localhost
// DB_USER=root
// DB_PASSWORD=password
// DB_NAME=php_schema
// DB_PORT=3306

// Connect without selecting database first
$conn = mysqli_connect($host, $user, $password, $db_name, $port);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS php_schema";
mysqli_query($conn, $sql);

// Select database
mysqli_select_db($conn, "php_schema");

// Create table if it doesn't exist
$createTable = "
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

mysqli_query($conn, $createTable);

?>