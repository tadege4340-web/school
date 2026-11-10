<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: loginf.php");
    exit();
}

require 'db.php';

$student_id = $_SESSION['username'];
$full_name = "Student";
$grade = "";
$section = "";

try {
    $stmt = $pdo->prepare("SELECT firstname, father_name, grandfather_name, grade, section FROM school2 WHERE student_id = ? LIMIT 1");
    $stmt->execute([$student_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $full_name = trim($row['firstname'] . ' ' . $row['father_name'] . ' ' . $row['grandfather_name']);
        $grade = $row['grade'];
        $section = $row['section'];
    }
} catch (PDOException $e) {}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal • EduSphere</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="admindashbord.css">
    
    <style>
        /* ========================================================
           THE ULTIMATE BOOTSTRAP OVERRIDE (KILLS THE BLUE LINE)
           ======================================================== */
        
        /* Force remove all borders, outlines, and backgrounds from links */
        .sidebar-nav a, 
        .sidebar-nav button, 
        .dropdown-btn {
            border: none !important;
            border-left: none !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            text-decoration: none !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            list-style-type: none !important;
        }

        /* Style the active link with a clean background, NO borders */
        .sidebar-nav a.active {
            background-color: rgba(255,255,255,0.15) !important;
            border-radius: 8px !important;
            margin: 0 15px !important;
            padding-left: 15px !important;
        }

        /* Ensure hover state is also clean */
        .sidebar-nav a:hover {
            background-color: rgba(255,255,255,0.08) !important;
            border-radius: 8px !important;
            margin: 0 15px !important;
            padding-left: 15px !important;
        }

        /* Fix icon spacing */
        .sidebar-nav a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Keep header on one line */
        .sidebar-header {
            display: flex !important;
            align-items: center !important;
            white-space: nowrap !important;
        }
    </style>
</head>
<body>

    <!-- FIXED SIDEBAR -->
    <div class="admin-sidebar" id="sidebar">
        
        <div class="sidebar-header">
            <i class="bi bi-mortarboard-fill"></i>
            <span>EduSphere Student</span>
            <button class="btn btn-close btn-close-white d-lg-none ms-auto" onclick="toggleSidebar()"></button>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-title"></div>
            
            <!-- Using inline style just in case Bootstrap has a class -->
            <a href="studentdashboard.php" class="<?= $current_page == 'student_dashboard_home.php' ? 'active' : '' ?>" style="border-left: none !important;">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="studentmycourse.php" class="<?= $current_page == 'student_mycourse.php' ? 'active' : '' ?>" style="border-left: none !important;">
                <i class="bi bi-journal-bookmark-fill"></i> My Courses
            </a>
            <a href="studentmygrade.php" class="<?= $current_page == 'student_mygrade.php' ? 'active' : '' ?>" style="border-left: none !important;">
                <i class="bi bi-bar-chart-fill"></i> My Grades
            </a>
            <a href="studentmystatus.php" class="<?= $current_page == 'student_mystatus.php' ? 'active' : '' ?>" style="border-left: none !important;">
                <i class="bi bi-person-check-fill"></i> My Status
            </a>
            
            <div class="sidebar-title mt-4"></div>
            <a href="#" style="border-left: none !important;">
                <i class="bi bi-info-circle-fill"></i> Placement Tutorial
            </a>

            <a href="logout.php" class="text-danger mt-4" style="border-left: none !important;">
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
                <h5 class="mb-0 fw-bold">Student Portal</h5>
                <small class="text-muted">Secondary School (Grades 9 - 12)</small>
            </div>
            
            <div class="header-user ms-auto d-flex align-items-center gap-3">
                <div class="text-end d-none d-md-block">
                    <span class="d-block fw-bold text-dark"><?= htmlspecialchars($full_name) ?></span>
                    <span class="badge bg-primary">Grade <?= htmlspecialchars($grade) ?> - <?= htmlspecialchars($section) ?></span>
                </div>
                <div class="avatar">
                    <?= strtoupper(substr($full_name, 0, 1)) ?>
                </div>
            </div>
        </header>

        <div class="content-wrapper">