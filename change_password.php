<?php
// change_password.php
session_start();
require 'db.php';

// 1. Security Check: Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: loginf.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$message = "";
$message_type = "";

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_pass = $_POST['new_password'] ?? '';
    $confirm_pass = $_POST['confirm_password'] ?? '';

    if (strlen($new_pass) < 7) {
        $message = "❌ Password must be at least 7 characters.";
        $message_type = "error";
    } elseif ($new_pass !== $confirm_pass) {
        $message = "❌ Passwords do not match.";
        $message_type = "error";
    } else {
        $hash = password_hash($new_pass, PASSWORD_DEFAULT);
        
        // Update the password and set must_change_password to 0
        $stmt = $pdo->prepare("UPDATE school1 SET password = ?, must_change_password = 0 WHERE id = ?");
        $stmt->execute([$hash, $user_id]);

        // Update session
        $_SESSION['must_change_password'] = 0;

        // Redirect to correct dashboard
        if ($_SESSION['role'] === 'admin') {
            header("Location: admindashbord.php");
        } elseif ($_SESSION['role'] === 'teacher') {
            header("Location: teacherdashboard.php");
        } else {
            header("Location: studentdashboard.php");
        }
        exit();
    }
}

// 3. Load the Frontend
include 'change_passwordf.php';
?>