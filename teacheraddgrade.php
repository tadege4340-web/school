<?php
// teacheraddgrade.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php';

// 1. Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: loginf.php");
    exit();
}

$teacher_id = $_SESSION['username']; // Teacher ID from login
$message = '';
$message_type = 'success';

// ============================================================
// HANDLE SAVE GRADES (POST)
// ============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_marks') {
    $course_code = $_POST['course_code'] ?? '';
    $marks = $_POST['marks'] ?? [];

    try {
        $pdo->beginTransaction();
        $count = 0;

        foreach ($marks as $student_id => $mark_obtained) {
            $mark_obtained = (float)$mark_obtained;
            
            // Only save if a mark was actually entered
            if ($mark_obtained >= 0) {
                // Check if a mark already exists for this student and subject
                $check = $pdo->prepare("SELECT id FROM marks WHERE student_id = ? AND subject = (SELECT course_name FROM courses WHERE course_code = ?)");
                $check->execute([$student_id, $course_code]);
                $existing = $check->fetch();

                if ($existing) {
                    // Update existing mark
                    $stmt = $pdo->prepare("UPDATE marks SET marks_obtained = ?, exam_date = CURDATE() WHERE id = ?");
                    $stmt->execute([$mark_obtained, $existing['id']]);
                } else {
                    // Insert new mark
                    $stmt = $pdo->prepare("INSERT INTO marks (student_id, subject, marks_obtained, total_marks, exam_date) 
                                           VALUES (?, (SELECT course_name FROM courses WHERE course_code = ?), ?, 100, CURDATE())");
                    $stmt->execute([$student_id, $course_code, $mark_obtained]);
                }
                $count++;
            }
        }
        $pdo->commit();
        $message = "✅ $count student mark(s) saved successfully!";
    } catch (PDOException $e) {
        $pdo->rollBack();
        $message = "❌ Error saving marks: " . $e->getMessage();
        $message_type = 'error';
    }
}

// ============================================================
// FETCH TEACHER'S ASSIGNED COURSES
// ============================================================
$my_courses = [];
try {
    $stmt = $pdo->prepare("
        SELECT c.course_code, c.course_name, c.grade, c.stream 
        FROM courses c
        JOIN teacher_courses tc ON c.course_code = tc.course_code
        WHERE tc.teacher_id = ?
        ORDER BY c.grade ASC, c.course_name ASC
    ");
    $stmt->execute([$teacher_id]);
    $my_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Error loading courses: " . $e->getMessage();
}

// ============================================================
// FETCH STUDENTS FOR SELECTED COURSE
// ============================================================
$f_course_code = $_GET['course_code'] ?? '';
$students_with_marks = [];

if ($f_course_code !== '') {
    try {
        // Fetch students enrolled in this course, and LEFT JOIN marks to see if they already have a grade
        $stmt = $pdo->prepare("
            SELECT s.student_id, s.firstname, s.father_name, 
                   m.marks_obtained, m.total_marks
            FROM student_courses sc
            JOIN school2 s ON sc.student_id = s.student_id
            LEFT JOIN marks m ON m.student_id = s.student_id AND m.subject = (SELECT course_name FROM courses WHERE course_code = ?)
            WHERE sc.course_code = ?
            ORDER BY s.firstname ASC
        ");
        $stmt->execute([$f_course_code, $f_course_code]);
        $students_with_marks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "Error loading students: " . $e->getMessage();
    }
}

// Load the HTML view
include 'teacheraddgradef.php';
?>