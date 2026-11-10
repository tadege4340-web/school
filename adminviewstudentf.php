<?php
// adminviewstudentf.php - Frontend UI
include 'header.php'; 
require 'adminviewstudent.php'; 
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">All Students</h4>
                <p class="text-muted mb-0">Manage Grades 9 - 12 students</p>
            </div>
            <a href="adminaddstudentf.php" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.6rem 1.5rem;">
                <i class="bi bi-plus-lg me-2"></i> Add New
            </a>
        </div>

        <!-- Messages -->
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success rounded-3"><i class="bi bi-check-circle-fill me-2"></i>Student deleted successfully from both records and login!</div>
        <?php endif; ?>
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger rounded-3"><i class="bi bi-x-circle-fill me-2"></i><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <!-- Search & Filter -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3 d-flex flex-wrap gap-3 align-items-center">
                <div class="input-group" style="max-width: 350px;">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInput" class="form-control bg-light border-start-0" placeholder="Search by ID, name, or room...">
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

        <!-- Table -->
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
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($students) > 0): ?>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">
                                            <?= htmlspecialchars($student['student_id'] ?? 'N/A') ?>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-3" style="width: 40px; height: 40px; font-size: 1rem; background: #e0e7ff; color: #4338ca;">
                                                    <?= strtoupper(substr($student['firstname'] ?? $student['username'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">
                                                        <?= htmlspecialchars(($student['firstname'] ?? '') . ' ' . ($student['father_name'] ?? '') . ' ' . ($student['grandfather_name'] ?? '')) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($student['age'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($student['gender'] ?? '-') ?></td> <!-- ADDED SEX DATA -->
                                        <td><?= htmlspecialchars($student['phone'] ?? '-') ?></td>
                                        <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle">Grade <?= htmlspecialchars($student['grade']) ?></span></td>
                                        <td><?= htmlspecialchars($student['section']) ?></td>
                                        <td>
                                            <?php if ($student['stream'] == 'General'): ?>
                                                <span class="text-muted">-</span>
                                            <?php else: ?>
                                                <span class="badge bg-info-subtle text-info border border-info-subtle"><?= htmlspecialchars($student['stream']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="adminupdatestudent.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-light text-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                            <a href="adminviewstudentf.php?delete_id=<?= $student['id'] ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Are you sure you want to delete this student? This will also remove their login access.');" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </a>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const gradeFilter = document.getElementById('gradeFilter');
        const tableRows = document.querySelectorAll('#studentTable tbody tr');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const selectedGrade = gradeFilter.value;

            tableRows.forEach(row => {
                if (row.cells.length < 9) return; // Updated to skip the "No students found" row

                // Indexes updated because of the new "Sex" column
                const idText = row.cells[0].textContent.toLowerCase();
                const nameText = row.cells[1].textContent.toLowerCase();
                const roomText = row.cells[6].textContent.toLowerCase();
                const gradeText = row.cells[5].textContent.trim();

                const matchesSearch = idText.includes(searchText) || nameText.includes(searchText) || roomText.includes(searchText);
                const matchesGrade = (selectedGrade === 'all') || gradeText.includes(selectedGrade);

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