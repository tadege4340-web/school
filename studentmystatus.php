<?php
// studentmystatus.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php';

// 1. Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: loginf.php");
    exit();
}

$student_id = $_SESSION['username'];
$student_info = [];
$marks_data = [];
$overall_average = 0;
$overall_status = "Pending";
$db_error = "";

try {
    // 2. Fetch Student Info
    $stmt = $pdo->prepare("SELECT firstname, father_name, grade, section FROM school2 WHERE student_id = ? LIMIT 1");
    $stmt->execute([$student_id]);
    $student_info = $stmt->fetch(PDO::FETCH_ASSOC);

    // 3. Fetch ONLY Approved Marks
    $sql = "SELECT 
                subject,
                marks_obtained,
                total_marks,
                exam_date
            FROM marks
            WHERE student_id = ? AND status = 'Approved'
            ORDER BY exam_date DESC, subject ASC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$student_id]);
    $marks_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4. Calculate Overall Average
    if (count($marks_data) > 0) {
        $total_obtained = 0;
        $total_possible = 0;

        foreach ($marks_data as $row) {
            $total_obtained += $row['marks_obtained'];
            $total_possible += $row['total_marks'];
        }

        if ($total_possible > 0) {
            $overall_average = round(($total_obtained / $total_possible) * 100, 1);
        }

        // Determine Pass/Fail (Assuming 50% is passing)
        if ($overall_average >= 50) {
            $overall_status = "Pass";
        } else {
            $overall_status = "Fail";
        }
    } else {
        $overall_status = "No Grades";
    }

} catch (PDOException $e) {
    $db_error = $e->getMessage();
}

// 5. Load the HTML view
include 'studentmystatusf.php';
?>