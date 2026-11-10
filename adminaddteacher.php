<?php
// adminaddteacher.php - Backend Logic
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'db.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginf.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Get Form Data
    $teacher_id = trim($_POST['teacher_id']);
    $full_name  = trim($_POST['full_name']);
    $age        = (int)$_POST['age'];
    $gender     = trim($_POST['gender']);
    $phone      = !empty(trim($_POST['phone'])) ? trim($_POST['phone']) : null;
    $address    = trim($_POST['address'] ?? '');
    $qualification = trim($_POST['qualification'] ?? '');
    $position   = trim($_POST['position'] ?? '');
    $hire_date  = !empty($_POST['hire_date']) ? $_POST['hire_date'] : null;
    $status     = trim($_POST['status'] ?? 'Active');
    
    // Default password for teachers
    $password = password_hash('teacher123', PASSWORD_BCRYPT); 

    if (empty($teacher_id) || empty($full_name) || empty($age) || empty($gender)) {
        header("Location: adminaddteacherf.php?error=Please fill in all required fields.");
        exit();
    }

    try {
        $pdo->beginTransaction();

        // 2. Insert into school3 (Teacher Records)
        $stmt3 = $pdo->prepare("INSERT INTO school3 (teacher_id, full_name, age, gender, phone, address, qualification, position, hire_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt3->execute([$teacher_id, $full_name, $age, $gender, $phone, $address, $qualification, $position, $hire_date, $status]);
        
        // 3. Insert into school1 (Login Table) - ADDED must_change_password = 1
        $stmt1 = $pdo->prepare("INSERT INTO school1 (student_id, username, password, role, age, gender, phone, must_change_password) VALUES (?, ?, ?, 'teacher', ?, ?, ?, 1)");
        $stmt1->execute([$teacher_id, $teacher_id, $password, $age, $gender, $phone]);
        
        $pdo->commit();
        
        // Redirect with success
        header("Location: adminaddteacherf.php?success=1&teacher_id=" . urlencode($teacher_id));
        exit();
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        
        // Handle duplicate errors (23000)
        if ($e->getCode() == 23000) {
            if (strpos($e->getMessage(), 'phone') !== false) {
                header("Location: adminaddteacherf.php?error=Error: This phone number is already registered.");
            } else {
                header("Location: adminaddteacherf.php?error=Error: The Teacher ID '" . urlencode($teacher_id) . "' already exists.");
            }
        } else {
            header("Location: adminaddteacherf.php?error=Database Error: " . urlencode($e->getMessage()));
        }
        exit();
    }
} else {
    header("Location: adminaddteacherf.php");
    exit();
}
?>