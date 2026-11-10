<?php
// login.php - Authentication Logic
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // 1. Check for empty fields
    if (empty($username) || empty($password)) {
        header("Location: loginf.php?error=emptyfields");
        exit();
    }

    try {
        // 2. Find user in school1 (Admins, Teachers, Students)
        $stmt = $pdo->prepare("SELECT * FROM school1 WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            // 3. Verify Password
            if (password_verify($password, $user['password'])) {
                
                // Set Session Variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Save the change password flag in session
                $_SESSION['must_change_password'] = $user['must_change_password'] ?? 0;

                // 4. FORCE PASSWORD CHANGE CHECK
                if ($_SESSION['must_change_password'] == 1) {
                    header("Location: change_password.php");
                    exit();
                }

                // 5. Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: admindashbord.php");
                    exit();
                } elseif ($user['role'] === 'teacher') {
                    header("Location: teacherdashboard.php");
                    exit();
                } elseif ($user['role'] === 'student') {
                    header("Location: studentdashboard.php");
                    exit();
                } else {
                    header("Location: school.php");
                    exit();
                }

            } else {
                header("Location: loginf.php?error=wrongpass");
                exit();
            }
        } else {
            header("Location: loginf.php?error=nousername");
            exit();
        }

    } catch (PDOException $e) {
        header("Location: loginf.php?error=servererror");
        exit();
    }
} else {
    header("Location: loginf.php");
    exit();
}
?>