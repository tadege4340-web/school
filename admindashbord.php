<?php
// admindashbord.php
include 'header.php'; 
require 'db.php'; 

// ======================
// FETCH REAL STATISTICS
// ======================
try {
    // 1. Total Students by Grade
    $grade_counts = [9 => 0, 10 => 0, 11 => 0, 12 => 0];
    $stmt = $pdo->query("SELECT grade, COUNT(*) as count FROM school2 GROUP BY grade");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $g = (int)$row['grade'];
        if (isset($grade_counts[$g])) {
            $grade_counts[$g] = (int)$row['count'];
        }
    }
    $total_students = array_sum($grade_counts);

    // 2. Student Gender Breakdown
    $male_students = $pdo->query("SELECT COUNT(*) FROM school2 WHERE gender = 'Male'")->fetchColumn() ?: 0;
    $female_students = $pdo->query("SELECT COUNT(*) FROM school2 WHERE gender = 'Female'")->fetchColumn() ?: 0;

    // 3. Teacher Statistics
    $total_teachers = $pdo->query("SELECT COUNT(*) FROM school3")->fetchColumn() ?: 0;
    $male_teachers = $pdo->query("SELECT COUNT(*) FROM school3 WHERE gender = 'Male'")->fetchColumn() ?: 0;
    $female_teachers = $pdo->query("SELECT COUNT(*) FROM school3 WHERE gender = 'Female'")->fetchColumn() ?: 0;

    // 4. Recent Students (Last 5)
    $recent_students = $pdo->query("SELECT student_id, firstname, father_name, grade, created_at FROM school2 ORDER BY id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<style>
    /* Custom styles to match the sleek look */
    .card-stat { border-radius: 12px; color: white; border: none; }
    .bg-g9 { background: linear-gradient(135deg, #3a7bd5, #2563eb); }
    .bg-g10 { background: linear-gradient(135deg, #10b981, #059669); }
    .bg-g11 { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .bg-g12 { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    
    .card-white { background: #fff; border-radius: 12px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
    .stat-value { font-size: 2rem; font-weight: 700; margin-bottom: 0; line-height: 1; }
    .stat-label { font-size: 0.85rem; font-weight: 500; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.5px; }
</style>

<!-- Top Row: Grade Statistics -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card card-stat bg-g9 p-3 h-100 shadow-sm">
            <p class="stat-label mb-1">Grade 9 Students</p>
            <h3 class="stat-value"><?= number_format($grade_counts[9]) ?></h3>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card card-stat bg-g10 p-3 h-100 shadow-sm">
            <p class="stat-label mb-1">Grade 10 Students</p>
            <h3 class="stat-value"><?= number_format($grade_counts[10]) ?></h3>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card card-stat bg-g11 p-3 h-100 shadow-sm">
            <p class="stat-label mb-1">Grade 11 Students</p>
            <h3 class="stat-value"><?= number_format($grade_counts[11]) ?></h3>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card card-stat bg-g12 p-3 h-100 shadow-sm">
            <p class="stat-label mb-1">Grade 12 Students</p>
            <h3 class="stat-value"><?= number_format($grade_counts[12]) ?></h3>
        </div>
    </div>
</div>

<!-- Middle Row: Charts & Teacher Stats -->
<div class="row g-4 mb-4">
    <!-- Students Overview Bar Chart -->
    <div class="col-lg-7">
        <div class="card card-white h-100 p-3">
            <h6 class="fw-bold mb-3 text-dark">Students Overview by Grade</h6>
            <div style="height: 250px; width: 100%;">
                <canvas id="gradeBarChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Teacher Stats & Doughnut Chart -->
    <div class="col-lg-5">
        <div class="row g-4 h-100">
            <!-- Teacher Counts -->
            <div class="col-12">
                <div class="card card-white p-3">
                    <h6 class="fw-bold mb-3 text-dark">Teacher Breakdown</h6>
                    <div class="d-flex justify-content-between text-center">
                        <div class="w-50 border-end">
                            <p class="text-muted mb-1" style="font-size: 0.8rem; font-weight: 600;">TOTAL</p>
                            <h3 class="fw-bold text-dark mb-0"><?= $total_teachers ?></h3>
                        </div>
                        <div class="w-50">
                            <p class="text-muted mb-1" style="font-size: 0.8rem; font-weight: 600;">M / F</p>
                            <h5 class="fw-bold mb-0">
                                <span class="text-primary"><?= $male_teachers ?></span> / 
                                <span style="color: #d946ef;"><?= $female_teachers ?></span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gender Doughnut Chart -->
            <div class="col-12">
                <div class="card card-white p-3 h-100">
                    <h6 class="fw-bold mb-3 text-dark">Student Gender Ratio</h6>
                    <div style="height: 150px; width: 100%; display: flex; justify-content: center;">
                        <canvas id="genderDoughnut"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Row: Recent Students -->
<div class="row g-4">
    <div class="col-lg-12">
        <div class="card card-white p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-dark">Recently Added Students</h6>
                <a href="adminviewstudentf.php" class="btn btn-sm btn-outline-primary" style="border-radius: 2rem;">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Full Name</th>
                            <th>Grade</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($recent_students) > 0): ?>
                            <?php foreach ($recent_students as $s): ?>
                                <tr>
                                    <td class="ps-3 fw-bold text-primary"><?= htmlspecialchars($s['student_id']) ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($s['firstname'] . ' ' . $s['father_name']) ?></td>
                                    <td><span class="badge bg-secondary">Grade <?= htmlspecialchars($s['grade']) ?></span></td>
                                    <td><small class="text-muted"><?= date('M d, Y', strtotime($s['created_at'])) ?></small></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center py-4 text-muted">No students added yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart JS Logic -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- BAR CHART (Students by Grade) ---
        const barCtx = document.getElementById('gradeBarChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'],
                datasets: [{
                    label: 'Total Students',
                    data: [<?= $grade_counts[9] ?>, <?= $grade_counts[10] ?>, <?= $grade_counts[11] ?>, <?= $grade_counts[12] ?>],
                    backgroundColor: ['#3a7bd5', '#10b981', '#f59e0b', '#8b5cf6'],
                    borderRadius: 6,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 4], color: '#e2e8f0' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- DOUGHNUT CHART (Student Gender) ---
        const doughnutCtx = document.getElementById('genderDoughnut').getContext('2d');
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [<?= $male_students ?>, <?= $female_students ?>],
                    backgroundColor: ['#3a7bd5', '#d946ef'],
                    borderWidth: 0,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right', labels: { boxWidth: 12, font: { size: 11, weight: 'bold' } } }
                }
            }
        });
    });
</script>

<?php include 'footer.php'; ?>