<?php
// adminapprovegradesf.php
include 'header.php'; 
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-check2-square me-2"></i>Approve Student Grades</h4>
        <p class="text-muted mb-0">Review and approve exam marks submitted by teachers</p>
    </div>
    <span class="badge bg-warning text-dark fs-6 px-3 py-2" style="border-radius: 0.5rem;">
        Pending: <?= count($pendingGrades) ?>
    </span>
</div>

<!-- Messages -->
<?php if ($message !== ''): ?>
    <div class="alert alert-<?= $message_type === 'success' ? 'success' : 'danger' ?> rounded-3">
        <?= $message ?>
    </div>
<?php endif; ?>

<!-- Filter Form -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form method="GET" class="d-flex flex-wrap gap-3 align-items-end">
            <div style="flex: 1; min-width: 200px;">
                <label class="form-label fw-bold text-muted" style="font-size: 0.85rem;">Filter by Grade</label>
                <select name="grade" class="form-select bg-light" onchange="this.form.submit()">
                    <option value="">All Grades</option>
                    <option value="9" <?= ($f_grade ?? '') == '9' ? 'selected' : '' ?>>Grade 9</option>
                    <option value="10" <?= ($f_grade ?? '') == '10' ? 'selected' : '' ?>>Grade 10</option>
                    <option value="11" <?= ($f_grade ?? '') == '11' ? 'selected' : '' ?>>Grade 11</option>
                    <option value="12" <?= ($f_grade ?? '') == '12' ? 'selected' : '' ?>>Grade 12</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 0.5rem;">Filter</button>
            <a href="adminapprovegrades.php" class="btn btn-outline-secondary" style="border-radius: 0.5rem;">Clear</a>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Student</th>
                        <th>Grade</th>
                        <th>Subject</th>
                        <th>Mark</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pendingGrades) > 0): ?>
                        <?php foreach ($pendingGrades as $row): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold"><?= htmlspecialchars($row['firstname'] . ' ' . $row['father_name']) ?></div>
                                    <small class="text-muted">ID: <?= htmlspecialchars($row['student_id']) ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        Grade <?= htmlspecialchars($row['grade']) ?>
                                    </span>
                                </td>
                                <td class="fw-bold"><?= htmlspecialchars($row['subject']) ?></td>
                                <td>
                                    <span class="fw-bold"><?= htmlspecialchars($row['marks_obtained']) ?></span> 
                                    <span class="text-muted">/ <?= htmlspecialchars($row['total_marks']) ?></span>
                                </td>
                                <td class="text-end pe-4">
                                    <form method="POST" style="display:inline-block;">
                                        <input type="hidden" name="mark_id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="action" value="approve" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Approve this grade?')">
                                            <i class="bi bi-check-lg me-1"></i> Approve
                                        </button>
                                    </form>
                                    
                                    <button type="button" class="btn btn-sm btn-danger rounded-pill px-3" onclick="openRejectModal(<?= $row['id'] ?>)">
                                        <i class="bi bi-x-lg me-1"></i> Reject
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-clipboard-check fs-1 d-block mb-3"></i>
                                <h5>No pending grades</h5>
                                <p class="mb-0">All submitted grades have been reviewed.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1050; align-items:center; justify-content:center;">
    <div class="card p-4" style="width:400px; border-radius:1rem; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
        <h5 class="fw-bold mb-3 text-danger"><i class="bi bi-x-circle-fill me-2"></i>Reject Grade</h5>
        <form method="POST">
            <input type="hidden" name="mark_id" id="reject_mark_id">
            <input type="hidden" name="action" value="reject">
            
            <label class="form-label text-muted">Reason for rejection:</label>
            <textarea name="reason" class="form-control mb-3" rows="3" required placeholder="Explain to the teacher why this grade is wrong..."></textarea>
            
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-light" onclick="document.getElementById('rejectModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-danger">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(id) {
    document.getElementById('reject_mark_id').value = id;
    document.getElementById('rejectModal').style.display = 'flex';
}
</script>

<?php include 'footer.php'; ?>