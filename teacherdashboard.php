<?php
// teacherdashboard.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php'; 

// Security Check: Only allow teachers
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: loginf.php");
    exit();
}

$display_name = "Teacher"; 
$teacher_id = $_SESSION['username']; // In our system, username = teacher_id

try {
    // Get the full name from the school3 (teachers) table using PDO
    $sql = "SELECT full_name FROM school3 WHERE teacher_id = :tid LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['tid' => $teacher_id]);
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        $display_name = htmlspecialchars($row['full_name']);
    }
} catch (PDOException $e) {
    // If there is an error, it will just keep the default "Teacher" name
}

// Load the HTML frontend
include 'teacherdashboardf.php';
?>