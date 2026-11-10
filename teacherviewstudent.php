<?php
// teacherviewstudent.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php';

// 1. Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: loginf.php");
    exit();
}

// 2. Get Teacher's ID from the session
// In our system, the teacher logs in using their Teacher ID as the username
$teacher_id = $_SESSION['username']; 

// 3. Initialize Filters
$f_grade  = trim($_GET['grade'] ?? '');
$f_search = trim($_GET['search'] ?? '');

// 4. Build Query
// We join teacher_courses -> student_courses -> school2 to find all students taught by this teacher
$sql = "SELECT DISTINCT s.student_id, s.firstname, s.father_name, s.grandfather_name,
               s.gender, s.phone, s.grade, s.section, s.stream
        FROM school2 s
        JOIN student_courses sc ON s.student_id = sc.student_id
        JOIN teacher_courses tc ON sc.course_code = tc.course_code
        WHERE tc.teacher_id = :tid";

$params = ['tid' => $teacher_id];

// Filter by Grade (9, 10, 11, 12)
if ($f_grade !== '') {
    $sql .= " AND s.grade = :grade";
    $params['grade'] = $f_grade;
}

// Search Filter (Name or ID)
if ($f_search !== '') {
    $sql .= " AND (s.student_id LIKE :search1 OR s.firstname LIKE :search2 OR s.father_name LIKE :search3)";
    $like = '%' . $f_search . '%';
    $params['search1'] = $like;
    $params['search2'] = $like;
    $params['search3'] = $like;
}

$sql .= " ORDER BY s.grade ASC, s.section ASC, s.firstname ASC";

$students = [];
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $db_error = $e->getMessage();
}

// 5. Counts
$totalFiltered = count($students);

// Count total unique students assigned to this teacher (without filters)
$totalAll = 0;
try {
    $stmt_count = $pdo->prepare("
        SELECT COUNT(DISTINCT s.student_id) AS c 
        FROM school2 s 
        JOIN student_courses sc ON s.student_id = sc.student_id 
        JOIN teacher_courses tc ON sc.course_code = tc.course_code 
        WHERE tc.teacher_id = :tid
    ");
    $stmt_count->execute(['tid' => $teacher_id]);
    $totalAll = (int)$stmt_count->fetchColumn();
} catch (PDOException $e) {}

// 6. Include the View
include 'teacherviewstudentf.php';
?>