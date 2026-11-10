<?php
// studentmycourse.php - Backend Logic
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php';

// 1. Fallback check for student ID
$student_id = $_SESSION['username'] ?? $_SESSION['student_id'] ?? '';
$courses = [];
$db_error = "";

if (empty($student_id)) {
    $db_error = "Error: You are not logged in properly. Please log out and log in again.";
} else {
    try {
        // 2. Fetch the courses and marks
        $sql = "SELECT 
                    sc.course_code, 
                    c.course_name, 
                    c.grade, 
                    c.stream,
                    m.marks_obtained,
                    m.status AS grade_status
                FROM student_courses sc
                INNER JOIN courses c ON c.course_code = sc.course_code
                LEFT JOIN marks m ON m.student_id = sc.student_id AND m.subject = c.course_name
                WHERE sc.student_id = :sid
                ORDER BY c.grade ASC, c.course_name ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['sid' => $student_id]);
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $db_error = "Database Error: " . $e->getMessage();
    }
}

// Load the Frontend UI
include 'studentmycoursef.php';
?>