```php
<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php
// ======================
// ADMIN CHECK
// ======================
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<p style='color:red; font-weight:bold; text-align:center;'>Only admin can view courses.</p>";
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
            $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
            $stmt->execute([$delete_id]);

            if ($stmt->rowCount() > 0) {
                $message = "Course deleted successfully!";
                $message_type = "success";
            } else {
                $message = "No course found with this ID.";
            }
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
        }
    } else {
        $message = "Invalid Course ID.";
    }
}

// ======================
// FETCH ALL COURSES
// ======================
try {
    $stmt = $pdo->query("SELECT * FROM courses ORDER BY grade ASC, stream ASC, course_name ASC");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<div class="row justify-content-center">
    <div class="col-lg-12">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-primary">
                    <i class="bi bi-journal-bookmark-fill me-2"></i>All Courses
                </h4>
                <p class="text-muted mb-0">Manage subjects for Grades 9 - 12</p>
            </div>

            <a href="adminaddcoursef.php" class="btn btn-primary"
               style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.6rem 1.5rem;">
                <i class="bi bi-plus-lg me-2"></i> Add New Course
            </a>
        </div>

        <!-- Messages -->
        <?php if ($message !== ''): ?>
            <div class="alert alert-<?= $message_type === 'success' ? 'success' : 'danger' ?> rounded-3">
                <i class="bi bi-<?= $message_type === 'success' ? 'check-circle-fill' : 'x-circle-fill' ?> me-2"></i>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Search & Filter -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3 d-flex flex-wrap gap-3 align-items-center">

                <div class="input-group" style="max-width: 350px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text" id="searchInput"
                           class="form-control bg-light border-start-0"
                           placeholder="Search by code, name, or stream...">
                </div>

                <select id="gradeFilter" class="form-select bg-light" style="max-width: 200px;">
                    <option value="all">Filter by Grade (All)</option>
                    <option value="9">Grade 9</option>
                    <option value="10">Grade 10</option>
                    <option value="11">Grade 11</option>
                    <option value="12">Grade 12</option>
                </select>

            </div>
        </div>

        <!-- Courses Table -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0" id="courseTable">

                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Course Code</th>
                                <th>Course Name</th>
                                <th>Grade</th>
                                <th>Stream</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (count($courses) > 0): ?>

                                <?php foreach ($courses as $row): ?>

                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">
                                            <?= htmlspecialchars($row['course_code']) ?>
                                        </td>

                                        <td class="fw-bold">
                                            <?= htmlspecialchars($row['course_name']) ?>
                                        </td>

                                        <td>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                Grade <?= htmlspecialchars($row['grade']) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <?php if ($row['stream'] == 'General' || empty($row['stream'])): ?>
                                                <span class="text-muted">General</span>
                                            <?php else: ?>
                                                <span class="badge bg-info-subtle text-info border border-info-subtle">
                                                    <?= htmlspecialchars($row['stream']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-end pe-4">

                                            <!-- Update Link -->
                                            <a href="adminupdatecourse.php?id=<?= $row['id'] ?>"
                                               class="btn btn-sm btn-light text-warning"
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <!-- Delete Form -->
                                            <form method="POST" style="display:inline-block; margin:0;">

                                                <input type="hidden" name="delete_id"
                                                       value="<?= $row['id'] ?>">

                                                <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this course?');"
                                                        class="btn btn-sm btn-light text-danger"
                                                        title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </form>

                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <!-- RED NO COURSES FOUND MESSAGE -->
                                <tr>
                                    <td colspan="5" class="text-center py-5">

                                        <i class="bi bi-exclamation-circle-fill fs-1 d-block mb-3 text-danger"></i>

                                        <h5 class="text-danger fw-bold">
                                            No Courses Found!
                                        </h5>

                                        <p class="text-danger mb-0">
                                            There are currently no courses available in the system.
                                        </p>

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

<!-- JavaScript for Live Search & Filter -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    const searchInput = document.getElementById('searchInput');
    const gradeFilter = document.getElementById('gradeFilter');
    const tableRows = document.querySelectorAll('#courseTable tbody tr');

    function filterTable() {

        const searchText = searchInput.value.toLowerCase();
        const selectedGrade = gradeFilter.value;

        tableRows.forEach(row => {

            if (row.cells.length < 5) return;

            const codeText = row.cells[0].textContent.toLowerCase();
            const nameText = row.cells[1].textContent.toLowerCase();
            const streamText = row.cells[3].textContent.toLowerCase();
            const gradeText = row.cells[2].textContent.trim();

            const matchesSearch =
                codeText.includes(searchText) ||
                nameText.includes(searchText) ||
                streamText.includes(searchText);

            const matchesGrade =
                (selectedGrade === 'all') ||
                gradeText.includes(selectedGrade);

            if (matchesSearch && matchesGrade) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }

        });
    }

    searchInput.addEventListener('input', filterTable);
    gradeFilter.addEventListener('change', filterTable);

});
</script>

<?php include 'footer.php'; ?>
```