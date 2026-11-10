<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php
// Admin Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginf.php");
    exit();
}

try {
    // Get total counts
    $total_teachers = $pdo->query("SELECT COUNT(*) FROM school3")->fetchColumn();
    $total_male = $pdo->query("SELECT COUNT(*) FROM school3 WHERE gender = 'Male'")->fetchColumn();
    $total_female = $pdo->query("SELECT COUNT(*) FROM school3 WHERE gender = 'Female'")->fetchColumn();

    // Fetch all teachers for the list
    $stmt = $pdo->query("SELECT * FROM school3 ORDER BY full_name ASC");
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0" style="color: #0b1e33;"><i class="bi bi-people-fill me-2"></i>All Teachers Overview</h4>
                <p class="text-muted mb-0">Summary of all teaching staff</p>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                    <h5 class="text-muted mb-2">Total Teachers</h5>
                    <h2 class="fw-bold mb-0 text-dark"><?= $total_teachers ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                    <h5 class="text-muted mb-2">Male Teachers</h5>
                    <h2 class="fw-bold mb-0 text-primary"><?= $total_male ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                    <h5 class="text-muted mb-2">Female Teachers</h5>
                    <h2 class="fw-bold mb-0" style="color: #d946ef;"><?= $total_female ?></h2>
                </div>
            </div>
        </div>

        <!-- Full List -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="fw-bold mb-0">All Teachers List</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Teacher ID</th>
                                <th>Full Name</th>
                                <th>Sex</th>
                                <th>Phone</th>
                                <th>Position</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($teachers) > 0): ?>
                                <?php foreach ($teachers as $t): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary"><?= htmlspecialchars($t['teacher_id']) ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($t['full_name']) ?></td>
                                        <td>
                                            <?php if ($t['gender'] == 'Male'): ?>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Male</span>
                                            <?php else: ?>
                                                <span class="badge border" style="background-color: #fdf4ff; color: #d946ef; border-color: #f5d0fe !important;">Female</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($t['phone'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($t['position'] ?? '—') ?></td>
                                        <td>
                                            <span class="badge <?= $t['status'] == 'Active' ? 'bg-success' : 'bg-secondary' ?>">
                                                <?= htmlspecialchars($t['status'] ?? 'Active') ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center py-4 text-muted">No teachers found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>