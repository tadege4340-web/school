<?php
// adminviewteacher.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php'; 

// Security check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginf.php");
    exit();
}

// ======================
// HANDLE DELETE REQUEST
// ======================
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    try {
        $pdo->beginTransaction();

        // 1. Fetch teacher_id to delete from school1
        $stmt = $pdo->prepare("SELECT teacher_id FROM school3 WHERE id = ?");
        $stmt->execute([$delete_id]);
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($teacher) {
            // 2. Delete from school3 (Records)
            $del3 = $pdo->prepare("DELETE FROM school3 WHERE id = ?");
            $del3->execute([$delete_id]);

            // 3. Delete from school1 (Login Table)
            $del1 = $pdo->prepare("DELETE FROM school1 WHERE student_id = ?");
            $del1->execute([$teacher['teacher_id']]);

            $pdo->commit();
            header("Location: adminviewteacherf.php?msg=deleted");
            exit();
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        header("Location: adminviewteacherf.php?error=" . urlencode("Could not delete teacher: " . $e->getMessage()));
        exit();
    }
}

// ======================
// FETCH ALL TEACHERS
// ======================
try {
    $stmt = $pdo->query("SELECT * FROM school3 ORDER BY full_name ASC");
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>