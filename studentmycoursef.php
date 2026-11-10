<?php
// studentmycoursef.php - Frontend UI
include 'studentheader.php'; 
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-journal-bookmark-fill me-2"></i>My Courses</h4>
                <p class="text-muted mb-0">Your enrolled subjects and grades</p>
            </div>
            <div class="badge bg-primary fs-6 px-3 py-2" style="border-radius: 0.5rem;">
                Total: <?= count($courses) ?> Courses
            </div>
        </div>

        <?php if (!empty($db_error)): ?>
            <div class="alert alert-danger rounded-3"><i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($db_error) ?></div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Course Code</th>
                                <th>Course Name</th>
                                <th>Grade</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($courses) > 0): ?>
                                <?php foreach ($courses as $row): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary"><?= htmlspecialchars($row['course_code'] ?? '—') ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($row['course_name'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($row['grade'] ?? '—') ?></td>
                                        <td>
                                            <?php if (($row['grade_status'] ?? '') === 'Approved'): ?>
                                                <span class="badge bg-success">Approved</span>
                                            <?php elseif (($row['marks_obtained'] ?? '') !== null && ($row['marks_obtained'] ?? '') !== ''): ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Not Graded</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-journal-x fs-1 d-block mb-3"></i>
                                        You are not enrolled in any courses yet.
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

<?php include 'studentfooter.php'; ?>