<?php
// admincourseassignstudent.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php'; 

// Admin Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginf.php");
    exit();
}

$message = "";
$message_type = "success";

// ======================
// HANDLE BULK ASSIGNMENT
// ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign'])) {
    $student_ids = $_POST['student_ids'] ?? [];
    $course_codes = $_POST['course_codes'] ?? [];
    $grade = $_POST['current_grade'] ?? '';
    $stream = $_POST['current_stream'] ?? '';

    if (empty($student_ids) || empty($course_codes)) {
        $message = "Please select at least one student and one course.";
        $message_type = "error";
    } else {
        try {
            $pdo->beginTransaction();
            $inserted = 0;
            $skipped = 0;

            foreach ($student_ids as $sid) {
                foreach ($course_codes as $ccode) {
                    // Check if already assigned to prevent duplicates
                    $check = $pdo->prepare("SELECT id FROM student_courses WHERE student_id = ? AND course_code = ?");
                    $check->execute([$sid, $ccode]);
                    
                    if ($check->rowCount() == 0) {
                        $stmt = $pdo->prepare("INSERT INTO student_courses (student_id, course_code, grade, stream) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$sid, $ccode, $grade, $stream]);
                        $inserted++;
                    } else {
                        $skipped++;
                    }
                }
            }
            $pdo->commit();
            $message = "Successfully assigned $inserted course records! ($skipped already existed and were skipped).";
            $message_type = "success";
        } catch (PDOException $e) {
            $pdo->rollBack();
            $message = "Database Error: " . $e->getMessage();
            $message_type = "error";
        }
    }
}

// ======================
// FETCH FILTERS
// ======================
$filter_grade = trim($_GET['grade'] ?? '');
$filter_stream = trim($_GET['stream'] ?? '');

$students = [];
$courses = [];

if ($filter_grade !== '') {
    // Fetch Students
    $sql = "SELECT student_id, firstname, father_name FROM school2 WHERE grade = ?";
    $params = [$filter_grade];
    
    if ($filter_stream !== '' && ($filter_grade == '11' || $filter_grade == '12')) {
        $sql .= " AND stream = ?";
        $params[] = $filter_stream;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Courses
    $sql_c = "SELECT course_code, course_name FROM courses WHERE grade = ?";
    $params_c = [$filter_grade];

    if ($filter_stream !== '' && ($filter_grade == '11' || $filter_grade == '12')) {
        $sql_c .= " AND stream = ?";
        $params_c[] = $filter_stream;
    }

    $stmt_c = $pdo->prepare($sql_c);
    $stmt_c->execute($params_c);
    $courses = $stmt_c->fetchAll(PDO::FETCH_ASSOC);
}
?>