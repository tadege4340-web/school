<?php
// db.php - Database Connection
$host = 'localhost';
$dbname = 'school';
$username = 'root';
$password = 'root'; // <--- Change this from '' to 'root'

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>