<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php
// ======================
// ADMIN CHECK
// ======================
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<p style='color:red; font-weight:bold; text-align:center;'>Only admin can delete teachers.</p>";
    include 'footer.php';
    exit();
}

$message = "";
$message_type = "error";

// ======================
// HANDLE DELETE (PDO)
// ======================
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];

    if ($delete_id > 0) {
        try {
            $pdo->beginTransaction();

            // 1. Fetch teacher_id to delete from school1
            $stmt = $pdo->prepare("SELECT teacher_id FROM school3 WHERE id = ?");
            $stmt->execute([$delete_id]);
            $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($teacher) {
                // 2. Delete from school3 (Records)
                $del3 = $pdo->prepare("DELETE FROM school3 WHERE id = ?");
                $del3->execute([$delete_id]);

                // 3. Delete from school1 (Login Table)
                $del1 = $pdo->prepare("DELETE FROM school1 WHERE student_id = ?");
                $del1->execute([$teacher['teacher_id']]);

                $pdo->commit();
                $message = "Teacher deleted successfully from both records and login!";
                $message_type = "success";
            } else {
                $message = "No teacher found with this ID.";
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            $message = "Database error: " . $e->getMessage();
        }
    } else {
        $message = "Invalid Teacher ID.";
    }
}

// ======================
// FETCH ALL TEACHERS
// ======================
try {
    $stmt = $pdo->query("SELECT * FROM school3 ORDER BY full_name ASC");
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-danger"><i class="bi bi-trash-fill me-2"></i>Delete Teacher</h4>
                <p class="text-muted mb-0">Remove teacher records permanently</p>
            </div>
        </div>

        <!-- Messages -->
        <?php if ($message !== ''): ?>
            <div class="alert alert-<?= $message_type === 'success' ? 'success' : 'danger' ?> rounded-3">
                <i class="bi bi-<?= $message_type === 'success' ? 'check-circle-fill' : 'x-circle-fill' ?> me-2"></i>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Search Bar -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <div class="input-group" style="max-width: 400px;">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInput" class="form-control bg-light border-start-0" placeholder="Search by ID, name, or phone...">
                </div>
            </div>
        </div>

        <!-- Teachers Table -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="teacherTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Teacher ID</th>
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Phone</th>
                                <th>Qualification</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($teachers)): ?>
                                <?php foreach ($teachers as $row): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">
                                            <?= htmlspecialchars($row['teacher_id'] ?? '—') ?>
                                        </td>
                                        <td>
                                            <div class="fw-bold">
                                                <?= htmlspecialchars($row['full_name'] ?? '—') ?>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($row['age'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($row['gender'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($row['phone'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($row['qualification'] ?? '—') ?></td>
                                        <td>
                                            <?php if (($row['status'] ?? '') == 'Active'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                            <?php elseif (($row['status'] ?? '') == 'On Leave'): ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">On Leave</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Retired</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <form method="POST" style="margin:0;">
                                                <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                                <button type="submit"
                                                        onclick="return confirm('Are you sure you want to permanently delete this teacher? This will also remove their login access.');"
                                                        class="btn btn-sm btn-danger" style="border-radius: 0.5rem;">
                                                    <i class="bi bi-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-person-badge fs-1 d-block mb-3"></i>
                                        No teachers found in the system.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- JavaScript for Live Search -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#teacherTable tbody tr');

        searchInput.addEventListener('input', function() {
            const searchText = this.value.toLowerCase();

            tableRows.forEach(row => {
                // Skip the "No teachers found" row
                if (row.cells.length < 8) return;

                const idText = row.cells[0].textContent.toLowerCase();
                const nameText = row.cells[1].textContent.toLowerCase();
                const phoneText = row.cells[4].textContent.toLowerCase();

                // Check if the search text matches ID, Name, or Phone
                if (idText.includes(searchText) || nameText.includes(searchText) || phoneText.includes(searchText)) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });
        });
    });
</script>

<?php include 'footer.php'; ?>