<?php
// studentmystatusf.php - Frontend UI
include 'studentheader.php'; 
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-person-check-fill me-2"></i>My Academic Status</h4>
                <p class="text-muted mb-0">Overview of your approved exam results</p>
            </div>
        </div>

        <?php if (!empty($db_error)): ?>
            <div class="alert alert-danger rounded-3"><i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($db_error) ?></div>
        <?php endif; ?>

        <!-- Student Info Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #0b1e33, #3a7bd5); color: white;">
            <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-4">
                    <div class="avatar" style="width: 70px; height: 70px; font-size: 2rem; background: rgba(255,255,255,0.2);">
                        <?= strtoupper(substr($student_info['firstname'] ?? 'S', 0, 1)) ?>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1"><?= htmlspecialchars(($student_info['firstname'] ?? '') . ' ' . ($student_info['father_name'] ?? '')) ?></h3>
                        <p class="mb-0 opacity-75">
                            <i class="bi bi-person-badge me-1"></i> ID: <?= htmlspecialchars($student_id) ?> &nbsp; | &nbsp;
                            <i class="bi bi-book me-1"></i> Grade <?= htmlspecialchars($student_info['grade'] ?? 'N/A') ?> - <?= htmlspecialchars($student_info['section'] ?? 'N/A') ?>
                        </p>
                    </div>
                </div>
                
                <!-- Overall Average Box -->
                <div class="text-center bg-white text-dark p-3 rounded-4 shadow-sm mt-3 mt-md-0" style="min-width: 150px;">
                    <h6 class="text-muted mb-1 fw-bold">Overall Average</h6>
                    <h2 class="fw-bold mb-0 <?= $overall_average >= 50 ? 'text-success' : ($overall_average > 0 ? 'text-danger' : 'text-muted') ?>">
                        <?= $overall_average > 0 ? $overall_average . '%' : '—' ?>
                    </h2>
                    <span class="badge <?= $overall_status == 'Pass' ? 'bg-success' : ($overall_status == 'Fail' ? 'bg-danger' : 'bg-secondary') ?> mt-2">
                        <?= $overall_status ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Approved Marks Table -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Approved Exam Results</h5>
                <span class="badge bg-success"><?= count($marks_data) ?> Subjects</span>
            </div>
            <div class="card-body p-0 mt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Subject</th>
                                <th>Marks Obtained</th>
                                <th>Total Marks</th>
                                <th>Percentage</th>
                                <th>Status</th>
                                <th>Exam Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($marks_data) > 0): ?>
                                <?php foreach ($marks_data as $row): ?>
                                    <?php 
                                        $percent = ($row['total_marks'] > 0) ? round(($row['marks_obtained'] / $row['total_marks']) * 100, 1) : 0; 
                                        $isPass = $percent >= 50;
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">
                                            <?= htmlspecialchars($row['subject']) ?>
                                        </td>
                                        <td>
                                            <span class="fw-bold"><?= htmlspecialchars($row['marks_obtained']) ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($row['total_marks']) ?></td>
                                        <td>
                                            <div class="progress" style="height: 8px; width: 100px;">
                                                <div class="progress-bar <?= $isPass ? 'bg-success' : 'bg-danger' ?>" role="progressbar" style="width: <?= $percent ?>%"></div>
                                            </div>
                                            <small class="fw-bold mt-1"><?= $percent ?>%</small>
                                        </td>
                                        <td>
                                            <span class="badge <?= $isPass ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' ?>">
                                                <?= $isPass ? 'Pass' : 'Fail' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= !empty($row['exam_date']) ? date('M d, Y', strtotime($row['exam_date'])) : '—' ?>
                                            </small>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-clipboard-x fs-1 d-block mb-3"></i>
                                        <h5>No Approved Grades Yet</h5>
                                        <p class="mb-0">Your teachers may have submitted grades, but they are still awaiting Admin approval.</p>
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