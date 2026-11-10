<?php
// teacherviewgradef.php - Frontend UI
include 'teacherheader.php'; 
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-bar-chart-fill me-2"></i>View Student Grades</h4>
                <p class="text-muted mb-0">Review exam marks and performance for your courses</p>
            </div>
        </div>

        <?php if (isset($db_error)): ?>
            <div class="alert alert-danger rounded-3"><i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($db_error) ?></div>
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
                        <i class="bi bi-search me-1"></i> Load Grades
                    </button>
                </form>
            </div>
        </div>

        <!-- Grades Table -->
        <?php if ($f_course_code !== ''): ?>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Grades for: <?= htmlspecialchars($f_course_code) ?></h5>
                    <span class="badge bg-primary"><?= count($grades_list) ?> Students</span>
                </div>
                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Student ID</th>
                                    <th>Full Name</th>
                                    <th>Marks Obtained</th>
                                    <th>Total Marks</th>
                                    <th>Percentage</th>
                                    <th>Letter Grade</th>
                                    <th>Exam Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($grades_list) > 0): ?>
                                    <?php foreach ($grades_list as $row): ?>
                                        <?php 
                                            // Calculate Percentage and Grade
                                            $percent = 0;
                                            $letter = 'Pending';
                                            $badge_color = 'secondary';

                                            if ($row['marks_obtained'] !== null) {
                                                $percent = ($row['total_marks'] > 0) ? round(($row['marks_obtained'] / $row['total_marks']) * 100, 1) : 0;
                                                
                                                if ($percent >= 90) { $letter = 'A'; $badge_color = 'success'; }
                                                elseif ($percent >= 80) { $letter = 'B'; $badge_color = 'primary'; }
                                                elseif ($percent >= 70) { $letter = 'C'; $badge_color = 'info'; }
                                                elseif ($percent >= 60) { $letter = 'D'; $badge_color = 'warning'; }
                                                else { $letter = 'F'; $badge_color = 'danger'; }
                                            }
                                        ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-primary"><?= htmlspecialchars($row['student_id']) ?></td>
                                            <td class="fw-bold"><?= htmlspecialchars($row['firstname'] . ' ' . $row['father_name']) ?></td>
                                            <td>
                                                <?php if ($row['marks_obtained'] !== null): ?>
                                                    <span class="fw-bold"><?= htmlspecialchars($row['marks_obtained']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($row['total_marks'] ?? '100') ?></td>
                                            <td>
                                                <div class="progress" style="height: 8px; width: 100px;">
                                                    <div class="progress-bar bg-<?= $badge_color ?>" role="progressbar" style="width: <?= $percent ?>%"></div>
                                                </div>
                                                <small class="fw-bold mt-1"><?= $percent ?>%</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $badge_color ?> fs-6" style="border-radius: 0.5rem;">
                                                    <?= $letter ?>
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
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="bi bi-people fs-1 d-block mb-3"></i>
                                            No students are enrolled in this course yet.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center py-5 text-muted">
                    <i class="bi bi-arrow-up-circle fs-1 d-block mb-3"></i>
                    <h5>Select a Course to View Grades</h5>
                    <p>Choose one of your assigned courses from the dropdown above.</p>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include 'teacherfooter.php'; ?>