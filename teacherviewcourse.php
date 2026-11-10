<?php
// teacherviewcourse.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php';

// 1. Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: loginf.php");
    exit();
}

$my_courses = [];
$teacher_id = $_SESSION['username']; // Teacher ID from session

try {
    // 2. Join the courses table with the teacher_courses assignment table
    $sql = "SELECT c.course_code, c.course_name, c.grade, c.stream 
            FROM courses c
            JOIN teacher_courses tc ON c.course_code = tc.course_code
            WHERE tc.teacher_id = :tid
            ORDER BY c.grade ASC, c.course_name ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['tid' => $teacher_id]);
    
    $my_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $db_error = $e->getMessage();
}

// 3. Include the View
include 'teacherviewcoursef.php';
?>