<?php
// teacherviewgrade.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php';

// 1. Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: loginf.php");
    exit();
}

$teacher_id = $_SESSION['username']; // Teacher ID from login
$my_courses = [];
$grades_list = [];
$f_course_code = $_GET['course_code'] ?? '';

try {
    // 2. Fetch Teacher's Assigned Courses
    $stmt = $pdo->prepare("
        SELECT c.course_code, c.course_name, c.grade 
        FROM courses c
        JOIN teacher_courses tc ON c.course_code = tc.course_code
        WHERE tc.teacher_id = :tid
        ORDER BY c.grade ASC, c.course_name ASC
    ");
    $stmt->execute(['tid' => $teacher_id]);
    $my_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Fetch Grades for the Selected Course
    if ($f_course_code !== '') {
        // We join student_courses (to get the students) with the marks table (to get their scores)
        $stmt_g = $pdo->prepare("
            SELECT 
                s.student_id, 
                s.firstname, 
                s.father_name,
                m.marks_obtained,
                m.total_marks,
                m.exam_date
            FROM student_courses sc
            JOIN school2 s ON sc.student_id = s.student_id
            LEFT JOIN marks m ON m.student_id = s.student_id AND m.subject = (SELECT course_name FROM courses WHERE course_code = ?)
            WHERE sc.course_code = ?
            ORDER BY s.firstname ASC
        ");
        $stmt_g->execute([$f_course_code, $f_course_code]);
        $grades_list = $stmt_g->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    $db_error = $e->getMessage();
}

// 4. Load the View
include 'teacherviewgradef.php';
?>