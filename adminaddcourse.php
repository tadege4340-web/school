<?php
// adminaddcourse.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginf.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $course_code = trim($_POST['course_code']);
    $course_name = trim($_POST['course_name']);
    $grade       = trim($_POST['grade']);
    $stream      = ($grade == '11' || $grade == '12') ? trim($_POST['stream']) : 'General';

    if (empty($course_name) || empty($grade)) {
        header("Location: adminaddcoursef.php?error=Please fill in all required fields.");
        exit();
    }

    // AUTO-GENERATE CODE IF LEFT BLANK
    if (empty($course_code)) {
        // Take first 3 letters of the course name, uppercase them, add grade and random number
        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $course_name), 0, 3));
        $course_code = $prefix . "-" . $grade . "-" . rand(100, 999);
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO courses (course_code, course_name, grade, stream) VALUES (?, ?, ?, ?)");
        $stmt->execute([$course_code, $course_name, $grade, $stream]);
        
        header("Location: adminaddcoursef.php?success=1");
        exit();
        
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            header("Location: adminaddcoursef.php?error=Error: The Course Code '" . urlencode($course_code) . "' already exists.");
        } else {
            header("Location: adminaddcoursef.php?error=Database Error: " . urlencode($e->getMessage()));
        }
        exit();
    }
} else {
    header("Location: adminaddcoursef.php");
    exit();
}
?>