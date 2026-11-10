<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php';

// ADMIN CHECK
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginf.php");
    exit();
}

// FILTERS
$filter_grade = trim($_GET['grade'] ?? '');
$search       = trim($_GET['q']     ?? '');

// 1. Fetch Grades (Joining school2 for student details and marks table for grades)
// Assuming you have a 'marks' table that stores exams.
$sql = "SELECT 
            m.id,
            m.student_id,
            m.subject,
            m.marks_obtained,
            m.total_marks,
            s.firstname,
            s.father_name,
            s.grade,
            s.section
        FROM marks m
        JOIN school2 s ON s.student_id = m.student_id
        WHERE 1=1";

$params = [];

if ($filter_grade !== '') {
    $sql .= " AND s.grade = :grade";
    $params['grade'] = $filter_grade;
}

if ($search !== '') {
    $sql .= " AND (s.student_id LIKE :search OR s.firstname LIKE :search OR s.father_name LIKE :search)";
    $params['search'] = "%$search%";
}

$sql .= " ORDER BY s.grade ASC, s.section ASC, s.firstname ASC, m.subject ASC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $grades = [];
    $db_error = $e->getMessage();
}

// 2. Helper function to calculate Letter Grade based on average
function getLetterGrade($average) {
    if ($average >= 90) return ['A', 'success'];
    if ($average >= 80) return ['B', 'primary'];
    if ($average >= 70) return ['C', 'info'];
    if ($average >= 60) return ['D', 'warning'];
    return ['F', 'danger'];
}

$total_rows = count($grades);

// LOAD HEADER & VIEW
include 'header.php';
include 'adminviewgradesf.php';
include 'footer.php';
?>