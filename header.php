<?php
// header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginf.php");
    exit();
}

$welcome_name = $_SESSION['username'] ?? 'Admin';
$current_page = basename($_SERVER['PHP_SELF']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard • EduSphere</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="admindashbord.css">
</head>
<body>

    <!-- ================= SIDEBAR ================= -->
    <div class="admin-sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="bi bi-mortarboard-fill"></i>
            <span>EduSphere Admin</span>
            <button class="btn btn-close btn-close-white d-lg-none ms-auto" onclick="toggleSidebar()"></button>
        </div>

        <nav class="sidebar-nav">
            <!-- Dashboard -->
            <a href="admindashbord.php" class="<?= $current_page == 'admindashbord.php' ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            
            <!-- STUDENT DROPDOWN -->
            <button class="dropdown-btn" onclick="toggleDropdown('studentMenu')">
                <i class="bi bi-people-fill me-2"></i> STUDENT
            </button>
            <div class="dropdown-container" id="studentMenu" style="<?= in_array($current_page, ['adminaddstudentf.php', 'adminviewstudentf.php', 'adminupdatestudent.php', 'admindeletestudent.php', 'adminsearchstudent.php']) ? 'display: block;' : '' ?>">
                <a href="adminaddstudentf.php" class="<?= $current_page == 'adminaddstudentf.php' ? 'active' : '' ?>">Add Student</a>
                <a href="adminviewstudentf.php" class="<?= $current_page == 'adminviewstudentf.php' ? 'active' : '' ?>">View Students</a>
                <a href="adminupdatestudent.php" class="<?= $current_page == 'adminupdatestudent.php' ? 'active' : '' ?>">Update Student</a>
                <a href="admindeletestudent.php" class="<?= $current_page == 'admindeletestudent.php' ? 'active' : '' ?>">Delete Student</a>
                <a href="adminsearchstudent.php" class="<?= $current_page == 'adminsearchstudent.php' ? 'active' : '' ?>">Search Student</a>
            </div>

            <!-- TEACHER DROPDOWN -->
            <button class="dropdown-btn" onclick="toggleDropdown('teacherMenu')">
                <i class="bi bi-person-badge-fill me-2"></i> TEACHER
            </button>
            <div class="dropdown-container" id="teacherMenu" style="<?= strpos($current_page, 'teacher') !== false ? 'display: block;' : '' ?>">
                <a href="adminaddteacherf.php" class="<?= $current_page == 'adminaddteacherf.php' ? 'active' : '' ?>">Add Teacher</a>
                <a href="adminviewteacherf.php" class="<?= $current_page == 'adminviewteacherf.php' ? 'active' : '' ?>">View Teachers</a>
                <a href="admindeleteteacher.php" class="<?= $current_page == 'admindeleteteacher.php' ? 'active' : '' ?>">Delete Teacher</a>
                <a href="adminmaleteacher.php" class="<?= $current_page == 'adminmaleteacher.php' ? 'active' : '' ?>">Total Male Teacher</a>
                <a href="adminfemaleteacher.php" class="<?= $current_page == 'adminfemaleteacher.php' ? 'active' : '' ?>">Total Female Teacher</a>
                <a href="admintotalteacher.php" class="<?= $current_page == 'admintotalteacher.php' ? 'active' : '' ?>">Total Teacher</a>
            </div>

            <!-- COURSE DROPDOWN -->
            <button class="dropdown-btn" onclick="toggleDropdown('courseMenu')">
                <i class="bi bi-journal-bookmark-fill me-2"></i> COURSE
            </button>
            <div class="dropdown-container" id="courseMenu" style="<?= strpos($current_page, 'course') !== false ? 'display: block;' : '' ?>">
                <a href="adminaddcoursef.php" class="<?= $current_page == 'adminaddcoursef.php' ? 'active' : '' ?>">Add Course</a>
                <a href="adminviewcourses.php" class="<?= $current_page == 'adminviewcoursesf.php' ? 'active' : '' ?>">View Courses</a>
                <a href="admincourseassignstudentf.php" class="<?= $current_page == 'admincourseassignstudentf.php' ? 'active' : '' ?>">Assign Course For Student</a>
                <a href="admincourseassignteacherf.php" class="<?= $current_page == 'admincourseassignteacherf.php' ? 'active' : '' ?>">Assign Course For Teacher</a>
            </div>

            <!-- GRADE DROPDOWN -->
            <button class="dropdown-btn" onclick="toggleDropdown('gradeMenu')">
                <i class="bi bi-bar-chart-fill me-2"></i> GRADE
            </button>
            <div class="dropdown-container" id="gradeMenu" style="<?= strpos($current_page, 'grade') !== false ? 'display: block;' : '' ?>">
                <a href="adminviewgrades.php" class="<?= $current_page == 'adminviewgrades.php' ? 'active' : '' ?>">View Grades</a>
                <a href="adminapprovegrades.php" class="<?= $current_page == 'adminapprovegrades.php' ? 'active' : '' ?>">Approve Grades</a>
            </div>

            <a href="logout.php" class="text-danger mt-4"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </nav>
    </div>

    <!-- ================= MAIN CONTENT STARTS ================= -->
    <div class="main-content" id="main-content">
        
        <!-- FIXED Top Header -->
        <header class="top-header">
            <button class="btn btn-light d-lg-none me-3" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>
            
            <div class="header-title">
                <h5 class="mb-0 fw-bold">Admin Dashboard</h5>
                <small class="text-muted">Secondary School (Grades 9 - 12)</small>
            </div>
            
            <div class="header-user ms-auto d-flex align-items-center gap-3">
                <div class="text-end d-none d-md-block">
                    <span class="d-block fw-bold text-dark"><?= htmlspecialchars($welcome_name) ?></span>
                    <span class="badge bg-primary">Administrator</span>
                </div>
                <div class="avatar">
                    <?= strtoupper(substr($welcome_name, 0, 1)) ?>
                </div>
            </div>
        </header>

        <!-- OPENING WRAPPER FOR THE PAGE CONTENT -->
        <div class="content-wrapper">