<?php
// db.php - Database Connection for Aiven / Render
$host = 'mysql-6dee70c-tadege4340-a4ab.e.aivencloud.com'; // e.g., mysql-6dee70c-tadege4340-a4ab.aivencloud.com
$port = '26233'; // e.g., 26233
$dbname = 'school';
$username = 'avnadmin';
$password = 'AVNS_14Jp2RaqEQWPgFqS_D4';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // This line connects to the certificate you downloaded
        PDO::MYSQL_ATTR_SSL_CA => __DIR__ . '/ca.pem',
    ];
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>