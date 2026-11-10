<?php
// teacherdashboard.php
include 'teacherheader.php'; 
?>

<!-- Dashboard Content -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4" style="background: linear-gradient(135deg, #198754, #059669); color: white;">
            <h3 class="fw-bold mb-2">Welcome back, <?= htmlspecialchars(explode(' ', $display_name ?? 'Teacher')[0]) ?>! 👋</h3>
            <p class="mb-0 opacity-75">Access your courses, manage student grades, and view your class schedules from the menu on the left.</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- View Students -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 text-center p-4">
            <i class="bi bi-people-fill fs-1 text-primary mb-3"></i>
            <h5 class="fw-bold">View Students</h5>
            <p class="text-muted small">See the list of students assigned to your classes.</p>
            <a href="teacherviewstudent.php" class="btn btn-outline-primary mt-2 rounded-pill">Go to Students</a>
        </div>
    </div>
    
    <!-- My Courses -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 text-center p-4">
            <i class="bi bi-journal-bookmark-fill fs-1 text-success mb-3"></i>
            <h5 class="fw-bold">My Courses</h5>
            <p class="text-muted small">View the subjects and grades you are currently teaching.</p>
            <a href="teacherviewcourse.php" class="btn btn-outline-success mt-2 rounded-pill">View Courses</a>
        </div>
    </div>

    <!-- Manage Grades -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 text-center p-4">
            <i class="bi bi-bar-chart-fill fs-1 text-warning mb-3"></i>
            <h5 class="fw-bold">Manage Grades</h5>
            <p class="text-muted small">Enter exam marks and review student performance.</p>
            <a href="teacheraddgrade.php" class="btn btn-outline-warning mt-2 rounded-pill">Add Grades</a>
        </div>
    </div>
</div>

<?php include 'teacherfooter.php'; ?>