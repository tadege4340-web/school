<?php
// adminviewstudent.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginf.php");
    exit();
}

// Handle Delete Request
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    try {
        $stmt = $pdo->prepare("SELECT username FROM school2 WHERE id = ?");
        $stmt->execute([$delete_id]);
        $student = $stmt->fetch();
        
        if ($student) {
            $pdo->beginTransaction();
            $del2 = $pdo->prepare("DELETE FROM school2 WHERE id = ?");
            $del2->execute([$delete_id]);
            
            $del1 = $pdo->prepare("DELETE FROM school1 WHERE username = ?");
            $del1->execute([$student['username']]);
            
            $pdo->commit();
            header("Location: adminviewstudentf.php?msg=deleted");
            exit();
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        header("Location: adminviewstudentf.php?error=" . urlencode("Could not delete student: " . $e->getMessage()));
        exit();
    }
}

// Fetch all students
try {
    $stmt = $pdo->query("SELECT * FROM school2 ORDER BY grade ASC, section ASC, student_id ASC");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>