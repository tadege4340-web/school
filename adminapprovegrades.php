<?php
// adminapprovegrades.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';

// Security Check
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin'])) {
    header("Location: loginf.php");
    exit();
}

$message = "";
$message_type = "";

// ============================================================
// HANDLE POST — APPROVE / REJECT
// ============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    $action = $_POST['action'];
    $mark_id = (int)($_POST['mark_id'] ?? 0);
    $reason = trim($_POST['reason'] ?? '');

    if ($mark_id > 0) {
        try {
            if ($action === 'approve') {
                $upd = $pdo->prepare("UPDATE marks SET status = 'Approved' WHERE id = :id");
                $upd->execute(['id' => $mark_id]);
                
                $message = "✅ <strong>Grade Approved!</strong> The student can now view this mark.";
                $message_type = "success";
            } elseif ($action === 'reject') {
                if ($reason === '') {
                    $message = "⚠️ Please provide a reason for rejection.";
                    $message_type = "error";
                } else {
                    $upd = $pdo->prepare("UPDATE marks SET status = 'Rejected', rejection_reason = :reason WHERE id = :id");
                    $upd->execute(['reason' => $reason, 'id' => $mark_id]);

                    $message = "↩️ <strong>Grade Rejected!</strong> It has been returned to the teacher for editing.";
                    $message_type = "success";
                }
            }
        } catch (PDOException $e) {
            $message = "❌ Error: " . $e->getMessage();
            $message_type = "error";
        }
    }
}

// ============================================================
// FETCH PENDING GRADES
// ============================================================
$pendingGrades = [];
$f_grade = trim($_GET['grade'] ?? '');

try {
    $sql = "
        SELECT m.id, m.student_id, m.subject, m.marks_obtained, m.total_marks, m.exam_date,
               s.firstname, s.father_name, s.grade
        FROM marks m
        JOIN school2 s ON m.student_id = s.student_id
        WHERE m.status = 'Pending'";

    $params = [];
    if ($f_grade !== '') {
        $sql .= " AND s.grade = :grade";
        $params['grade'] = $f_grade;
    }

    $sql .= " ORDER BY m.exam_date DESC, s.grade ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $pendingGrades = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Error loading grades: " . $e->getMessage();
}

// Load the Frontend UI
include 'adminapprovegradesf.php';
?>