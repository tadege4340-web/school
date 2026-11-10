<?php
// teacheraddgradef.php - Frontend UI
include 'teacherheader.php'; 
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-pencil-square me-2"></i>Add / Edit Student Marks</h4>
                <p class="text-muted mb-0">Select a course to enter exam marks</p>
            </div>
        </div>

        <!-- Messages -->
        <?php if ($message !== ''): ?>
            <div class="alert alert-<?= $message_type ?> rounded-3">
                <i class="bi bi-<?= $message_type === 'success' ? 'check-circle-fill' : 'x-circle-fill' ?> me-2"></i>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Course Selection Form -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET" class="d-flex flex-wrap gap-3 align-items-end">
                    <div style="flex: 1; min-width: 300px;">
                        <label class="form-label fw-bold" style="color: #3a7bd5;">Select Your Course</label>
                        <select name="course_code" class="form-select bg-light" required onchange="this.form.submit()">
                            <option value="">-- Choose Course --</option>
                            <?php foreach ($my_courses as $c): ?>
                                <option value="<?= htmlspecialchars($c['course_code']) ?>" <?= $f_course_code == $c['course_code'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c['course_code'] . ' - ' . $c['course_name'] . ' (Grade ' . $c['grade'] . ')') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 0.5rem;">
                        <i class="bi bi-search me-1"></i> Load Students
                    </button>
                </form>
            </div>
        </div>

        <!-- Students Marks Entry Table -->
        <?php if ($f_course_code !== ''): ?>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Enter Marks for: <?= htmlspecialchars($f_course_code) ?></h5>
                    <span class="badge bg-primary"><?= count($students_with_marks) ?> Students</span>
                </div>
                <div class="card-body p-0 mt-3">
                    <form method="POST">
                        <input type="hidden" name="action" value="save_marks">
                        <input type="hidden" name="course_code" value="<?= htmlspecialchars($f_course_code) ?>">

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Student ID</th>
                                        <th>Full Name</th>
                                        <th style="width: 200px;">Marks (Out of 100)</th>
                                        <th>Current Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($students_with_marks) > 0): ?>
                                        <?php foreach ($students_with_marks as $s): ?>
                                            <tr>
                                                <td class="ps-4 fw-bold text-primary"><?= htmlspecialchars($s['student_id']) ?></td>
                                                <td class="fw-bold"><?= htmlspecialchars($s['firstname'] . ' ' . $s['father_name']) ?></td>
                                                <td>
                                                    <!-- Input for Marks -->
                                                    <input type="number" name="marks[<?= $s['student_id'] ?>]" 
                                                           class="form-control bg-light" 
                                                           min="0" max="100" step="0.5" 
                                                           value="<?= htmlspecialchars($s['marks_obtained'] ?? '') ?>" 
                                                           placeholder="Enter mark...">
                                                </td>
                                                <td>
                                                    <?php if ($s['marks_obtained'] !== null): ?>
                                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                            Saved: <?= $s['marks_obtained'] ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                                            Not Graded
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">
                                                <i class="bi bi-people fs-1 d-block mb-3"></i>
                                                No students are enrolled in this course yet.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if (count($students_with_marks) > 0): ?>
                            <div class="p-4 text-end border-top">
                                <button type="submit" class="btn btn-primary px-5 py-2" style="background-color: var(--primary-color); border-radius: 2rem; font-weight: 600;">
                                    <i class="bi bi-save me-2"></i> Save All Marks
                                </button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center py-5 text-muted">
                    <i class="bi bi-arrow-up-circle fs-1 d-block mb-3"></i>
                    <h5>Select a Course to Begin</h5>
                    <p>Choose one of your assigned courses from the dropdown above to load the students.</p>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include 'teacherfooter.php'; ?>