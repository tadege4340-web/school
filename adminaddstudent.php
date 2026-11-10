<?php
// adminaddstudent.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginf.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $student_id = trim($_POST['student_id']);
    $firstname = trim($_POST['firstname']);
    $father_name = trim($_POST['father_name']);
    $grandfather_name = trim($_POST['grandfather_name']);
    
    $age = (int)$_POST['age'];
    $gender = trim($_POST['gender']); 
    $phone = !empty(trim($_POST['phone'])) ? trim($_POST['phone']) : null;
    
    $grade = $_POST['grade'];
    $section = $_POST['section'];
    $stream = ($grade == '11' || $grade == '12') ? $_POST['stream'] : 'General';
    
    $password = password_hash('student123', PASSWORD_BCRYPT); 

    if (empty($student_id) || empty($firstname) || empty($father_name) || empty($grandfather_name) || empty($gender) || empty($grade) || empty($section)) {
        header("Location: adminaddstudentf.php?error=Please fill in all required fields.");
        exit();
    }

    try {
        $pdo->beginTransaction();

        // Insert into school2 (Detailed Records)
        $stmt2 = $pdo->prepare("INSERT INTO school2 (student_id, username, firstname, father_name, grandfather_name, password, age, gender, phone, grade, section, stream) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->execute([$student_id, $student_id, $firstname, $father_name, $grandfather_name, $password, $age, $gender, $phone, $grade, $section, $stream]);
        
        // Insert into school1 (Login Table) - ADDED must_change_password = 1
        $stmt1 = $pdo->prepare("INSERT INTO school1 (student_id, username, password, role, age, gender, phone, grade, section, stream, must_change_password) VALUES (?, ?, ?, 'student', ?, ?, ?, ?, ?, ?, 1)");
        $stmt1->execute([$student_id, $student_id, $password, $age, $gender, $phone, $grade, $section, $stream]);
        
        $pdo->commit();
        
        header("Location: adminaddstudentf.php?success=1&student_id=" . urlencode($student_id));
        exit();
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        if ($e->getCode() == 23000) {
            if (strpos($e->getMessage(), 'phone') !== false) {
                header("Location: adminaddstudentf.php?error=Error: This phone number is already registered to another student.");
            } else {
                header("Location: adminaddstudentf.php?error=Error: The Student ID '" . urlencode($student_id) . "' already exists.");
            }
        } else {
            header("Location: adminaddstudentf.php?error=Database Error: " . urlencode($e->getMessage()));
        }
        exit();
    }
} else {
    header("Location: adminaddstudentf.php");
    exit();
}
?>