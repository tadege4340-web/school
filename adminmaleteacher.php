<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php
// Admin Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginf.php");
    exit();
}

// Fetch Male Teachers
try {
    $stmt = $pdo->prepare("SELECT * FROM school3 WHERE gender = 'Male' ORDER BY full_name ASC");
    $stmt->execute();
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total = count($teachers);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-gender-male me-2"></i>Total Male Teachers</h4>
                <p class="text-muted mb-0">List of all male teachers in the school</p>
            </div>
            <div class="badge bg-primary fs-5 px-4 py-2" style="border-radius: 1rem;">
                Total: <?= $total ?>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Teacher ID</th>
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Phone</th>
                                <th>Qualification</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($total > 0): ?>
                                <?php foreach ($teachers as $t): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary"><?= htmlspecialchars($t['teacher_id']) ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($t['full_name']) ?></td>
                                        <td><?= htmlspecialchars($t['age'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($t['phone'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($t['qualification'] ?? '—') ?></td>
                                        <td>
                                            <span class="badge <?= $t['status'] == 'Active' ? 'bg-success' : 'bg-secondary' ?>">
                                                <?= htmlspecialchars($t['status'] ?? 'Active') ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center py-4 text-muted">No male teachers found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>