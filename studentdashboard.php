<?php
// studentdashboard.php
include 'studentheader.php'; 
require 'db.php';

$student_id = $_SESSION['username'];

// Fetch Quick Stats
$course_count = 0;
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM student_courses WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $course_count = $stmt->fetchColumn();
} catch(PDOException $e) {}
?>

<!-- Dashboard Content -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4" style="background: linear-gradient(135deg, #0b1e33, #3a7bd5); color: white;">
            <h3 class="fw-bold mb-2">Welcome back, <?= htmlspecialchars(explode(' ', $full_name)[0]) ?>! 👋</h3>
            <p class="mb-0 opacity-75">You are logged in as a Grade <?= htmlspecialchars($grade) ?> student in the <?= htmlspecialchars($section) ?> section.</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 d-flex flex-row align-items-center gap-3">
            <div class="stat-icon bg-primary-subtle text-primary" style="width: 60px; height: 60px; border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                <i class="bi bi-journal-bookmark-fill"></i>
            </div>
            <div>
                <h2 class="mb-0 fw-bold"><?= number_format($course_count) ?></h2>
                <p class="text-muted mb-0 fw-semibold">Enrolled Courses</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 d-flex flex-row align-items-center gap-3">
            <div class="stat-icon bg-success-subtle text-success" style="width: 60px; height: 60px; border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                <i class="bi bi-person-check-fill"></i>
            </div>
            <div>
                <h2 class="mb-0 fw-bold">Active</h2>
                <p class="text-muted mb-0 fw-semibold">Account Status</p>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mt-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-info-circle-fill text-primary me-2"></i>Getting Started</h5>
        <p class="text-muted">Use the sidebar on the left to view your courses and check your grades. If you notice any missing information, please contact the school administrator.</p>
    </div>
</div>

<?php include 'studentfooter.php'; ?>