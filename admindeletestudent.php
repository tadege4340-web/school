<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php
// ======================
// ADMIN CHECK
// ======================
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<p style='color:red; font-weight:bold; text-align:center;'>Only admin can delete students.</p>";
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

            // 1. Fetch username to delete from school1
            $stmt = $pdo->prepare("SELECT username FROM school2 WHERE id = ?");
            $stmt->execute([$delete_id]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($student) {
                // 2. Delete from school2
                $del2 = $pdo->prepare("DELETE FROM school2 WHERE id = ?");
                $del2->execute([$delete_id]);

                // 3. Delete from school1
                $del1 = $pdo->prepare("DELETE FROM school1 WHERE username = ?");
                $del1->execute([$student['username']]);

                $pdo->commit();
                $message = "Student deleted successfully from both records and login!";
                $message_type = "success";
            } else {
                $message = "No student found with this ID.";
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            $message = "Database error: " . $e->getMessage();
        }
    } else {
        $message = "Invalid Student ID.";
    }
}

// ======================
// FETCH ALL STUDENTS
// ======================
try {
    $stmt = $pdo->query("SELECT * FROM school2 ORDER BY grade ASC, section ASC, student_id ASC");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-danger"><i class="bi bi-trash-fill me-2"></i>Delete Student</h4>
                <p class="text-muted mb-0">Remove student records permanently</p>
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
                    <input type="text" id="searchInput" class="form-control bg-light border-start-0" placeholder="Search by ID, name, or room...">
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="studentTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Student ID</th>
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Sex</th> <!-- ADDED SEX -->
                                <th>Phone</th>
                                <th>Grade</th>
                                <th>Room</th>
                                <th>Stream</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($students)): ?>
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
                                        <td><?= htmlspecialchars($row['gender'] ?? '—') ?></td> <!-- ADDED SEX DATA -->
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
                                        <td class="text-end pe-4">
                                            <form method="POST" style="margin:0;">
                                                <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                                <button type="submit"
                                                        onclick="return confirm('Are you sure you want to permanently delete this student? This will also remove their login access.');"
                                                        class="btn btn-sm btn-danger" style="border-radius: 0.5rem;">
                                                    <i class="bi bi-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted"> <!-- Updated colspan to 9 -->
                                        <i class="bi bi-people fs-1 d-block mb-3"></i>
                                        No students found in the system.
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
        const tableRows = document.querySelectorAll('#studentTable tbody tr');

        searchInput.addEventListener('input', function() {
            const searchText = this.value.toLowerCase();

            tableRows.forEach(row => {
                // Skip the "No students found" row
                if (row.cells.length < 9) return; // Updated to 9 because of the new column

                // Indexes updated because of the new Sex column
                const idText = row.cells[0].textContent.toLowerCase();
                const nameText = row.cells[1].textContent.toLowerCase();
                const roomText = row.cells[6].textContent.toLowerCase();

                // Check if the search text matches ID, Name, or Room
                if (idText.includes(searchText) || nameText.includes(searchText) || roomText.includes(searchText)) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });
        });
    });
</script>

<?php include 'footer.php'; ?>