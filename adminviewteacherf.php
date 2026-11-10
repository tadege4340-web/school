<?php
// adminviewteacherf.php - Frontend UI
include 'header.php'; 
require 'adminviewteacher.php'; 
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <!-- Page Header & Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">All Teachers</h4>
                <p class="text-muted mb-0">Manage school staff and their records</p>
            </div>
            <a href="adminaddteacherf.php" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.6rem 1.5rem;">
                <i class="bi bi-plus-lg me-2"></i> Add New Teacher
            </a>
        </div>

        <!-- Messages -->
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success rounded-3"><i class="bi bi-check-circle-fill me-2"></i>Teacher deleted successfully from both records and login!</div>
        <?php endif; ?>
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger rounded-3"><i class="bi bi-x-circle-fill me-2"></i><?= htmlspecialchars($_GET['error']) ?></div>
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
                                <th>Position</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($teachers) > 0): ?>
                                <?php foreach ($teachers as $teacher): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">
                                            <?= htmlspecialchars($teacher['teacher_id'] ?? 'N/A') ?>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-3" style="width: 40px; height: 40px; font-size: 1rem; background: #dcfce7; color: #15803d;">
                                                    <?= strtoupper(substr($teacher['full_name'], 0, 1)) ?>
                                                </div>
                                                <div class="fw-bold">
                                                    <?= htmlspecialchars($teacher['full_name']) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($teacher['age'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($teacher['gender'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($teacher['phone'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($teacher['qualification'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($teacher['position'] ?? '—') ?></td>
                                        <td>
                                            <?php if ($teacher['status'] == 'Active'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                            <?php elseif ($teacher['status'] == 'On Leave'): ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">On Leave</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Retired</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="adminupdateteacher.php?id=<?= $teacher['id'] ?>" class="btn btn-sm btn-light text-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                            <a href="adminviewteacherf.php?delete_id=<?= $teacher['id'] ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Are you sure you want to delete this teacher? This will also remove their login access.');" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
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
                if (row.cells.length < 9) return; // Skip the "No teachers found" row

                const idText = row.cells[0].textContent.toLowerCase();
                const nameText = row.cells[1].textContent.toLowerCase();
                const phoneText = row.cells[4].textContent.toLowerCase();

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