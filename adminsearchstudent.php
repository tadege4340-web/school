<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php
// ======================
// ADMIN CHECK
// ======================
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<p style='color:red; font-weight:bold; text-align:center;'>Only admin can search students.</p>";
    include 'footer.php';
    exit();
}
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-search me-2"></i>Search Student</h4>
                <p class="text-muted mb-0">Find students by ID, Name, Phone, or Room</p>
            </div>
        </div>

        <!-- Search Form -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="POST" action="" class="d-flex flex-wrap gap-3 align-items-end">
                    <div class="flex-grow-1" style="max-width: 500px;">
                        <label class="form-label fw-bold" style="color: #3a7bd5;">Search Term</label>
                        <input type="text" name="searchKey" class="form-control bg-light"
                               value="<?= htmlspecialchars($_POST['searchKey'] ?? '') ?>"
                               placeholder="Enter ID, Name, Phone..." required>
                    </div>

                    <button type="submit" name="search" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.6rem 2rem;">
                        <i class="bi bi-search me-2"></i> Search
                    </button>
                    <a href="adminsearchstudent.php" class="btn btn-outline-secondary" style="border-radius: 2rem; padding: 0.6rem 2rem;">Clear</a>
                </form>
            </div>
        </div>

        <!-- Search Results -->
        <?php
        if (isset($_POST['search'])) {
            $key = trim($_POST['searchKey']);

            if ($key === '') {
                echo "<div class='alert alert-warning rounded-3'><i class='bi bi-exclamation-triangle-fill me-2'></i>Please enter a search term.</div>";
            } else {
                // ALWAYS USE "STARTS WITH" LOGIC
                $like = $key . '%';

                // Search in school2
                $sql = "SELECT * FROM school2
                        WHERE student_id        LIKE :key
                           OR firstname         LIKE :key
                           OR father_name       LIKE :key
                           OR grandfather_name  LIKE :key
                           OR phone             LIKE :key
                           OR section           LIKE :key
                           OR stream            LIKE :key
                           OR grade             LIKE :key
                        ORDER BY grade ASC, section ASC, student_id ASC";
                        
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['key' => $like]);
                    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($students) > 0):
        ?>
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Results (<?= count($students) ?>)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Student ID</th>
                                        <th>Full Name</th>
                                        <th>Age</th>
                                        <th>Sex</th>
                                        <th>Phone</th>
                                        <th>Grade</th>
                                        <th>Room</th>
                                        <th>Stream</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $row): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-primary">
                                                <?= htmlspecialchars($row['student_id'] ?? '—') ?>
                                            </td>
                                            <td>
                                                <div class="fw-bold">
                                                    <?= htmlspecialchars(($row['firstname'] ?? '') . ' ' . ($row['father_name'] ?? '') . ' ' . ($row['grandfather_name'] ?? '')) ?>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($row['age'] ?? '—') ?></td>
                                            <td><?= htmlspecialchars($row['gender'] ?? '—') ?></td>
                                            <td><?= htmlspecialchars($row['phone'] ?? '—') ?></td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                    Grade <?= htmlspecialchars($row['grade']) ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($row['section'] ?? '—') ?></td>
                                            <td>
                                                <?php if ($row['stream'] == 'General'): ?>
                                                    <span class="text-muted">-</span>
                                                <?php else: ?>
                                                    <span class="badge bg-info-subtle text-info border border-info-subtle"><?= htmlspecialchars($row['stream']) ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        <?php
                    else:
                        echo "<div class='alert alert-danger rounded-3'><i class='bi bi-x-circle-fill me-2'></i>No student found matching: <strong>" . htmlspecialchars($key) . "</strong></div>";
                    endif;

                } catch (PDOException $e) {
                    echo "<div class='alert alert-danger rounded-3'>Database Error: " . htmlspecialchars($e->getMessage()) . "</div>";
                }
            }
        }
        ?>

    </div>
</div>

<?php include 'footer.php'; ?>