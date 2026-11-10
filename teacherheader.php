<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: loginf.php");
    exit();
}

require 'db.php';

$teacher_id = $_SESSION['username'];
$display_name = "Teacher";

try {
    $stmt = $pdo->prepare("SELECT full_name FROM school3 WHERE teacher_id = ? LIMIT 1");
    $stmt->execute([$teacher_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) { $display_name = $row['full_name']; }
} catch (PDOException $e) {}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal • EduSphere</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="admindashbord.css">
    
    <style>
        /* KILL THE BULLET */
        .sidebar-nav a, .dropdown-btn {
            border-left: none !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            text-decoration: none !important;
        }
        .sidebar-nav a.active, .sidebar-nav a:hover {
            background-color: rgba(255,255,255,0.15) !important;
            border-radius: 8px !important;
            margin: 0 15px !important;
            padding-left: 15px !important;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="admin-sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="bi bi-mortarboard-fill"></i>
            <span>EduSphere Teacher</span>
            <button class="btn btn-close btn-close-white d-lg-none ms-auto" onclick="toggleSidebar()"></button>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-title">Teacher Menu</div>
            
            <a href="teacherdashboard.php" class="<?= $current_page == 'teacherdashboard.php' ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            
            <div class="dropdown-btn" onclick="toggleDropdown('studentsMenu')">
                <i class="bi bi-people-fill me-2"></i> Students
            </div>
            <div class="dropdown-container" id="studentsMenu">
                <a href="teacherviewstudent.php" class="<?= $current_page == 'teacherviewstudent.php' ? 'active' : '' ?>">View Students</a>
            </div>

            <div class="dropdown-btn" onclick="toggleDropdown('coursesMenu')">
                <i class="bi bi-journal-bookmark-fill me-2"></i> Courses
            </div>
            <div class="dropdown-container" id="coursesMenu">
                <a href="teacherviewcourse.php" class="<?= $current_page == 'teacherviewcourse.php' ? 'active' : '' ?>">View My Courses</a>
            </div>

            <div class="dropdown-btn" onclick="toggleDropdown('gradesMenu')">
                <i class="bi bi-bar-chart-fill me-2"></i> Grades
            </div>
            <div class="dropdown-container" id="gradesMenu">
                <a href="teacheraddgrade.php" class="<?= $current_page == 'teacheraddgrade.php' ? 'active' : '' ?>">Add Grade</a>
                <a href="teacherviewgrade.php" class="<?= $current_page == 'teacherviewgrade.php' ? 'active' : '' ?>">View Grades</a>
            </div>

            <a href="logout.php" class="text-danger mt-4">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </nav>
    </div>

    <!-- MAIN CONTENT STARTS -->
    <div class="main-content" id="main-content">
        <header class="top-header">
            <button class="btn btn-light d-lg-none me-3" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>
            
            <div class="header-title">
                <h5 class="mb-0 fw-bold">Teacher Portal</h5>
                <small class="text-muted">Secondary School (Grades 9 - 12)</small>
            </div>
            
            <div class="header-user ms-auto d-flex align-items-center gap-3">
                <div class="text-end d-none d-md-block">
                    <span class="d-block fw-bold text-dark"><?= htmlspecialchars($display_name) ?></span>
                    <span class="badge bg-primary">Teacher</span>
                </div>
                <div class="avatar" style="background: linear-gradient(135deg, #198754, #059669);">
                    <?= strtoupper(substr($display_name, 0, 1)) ?>
                </div>
            </div>
        </header>

        <!-- OPENING WRAPPER FOR PAGE CONTENT -->
        <div class="content-wrapper">