<?php
// teacherviewstudentf.php - Frontend UI
include 'teacherheader.php'; // We will create this to keep the sidebar consistent
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-people-fill me-2"></i>My Assigned Students</h4>
                <p class="text-muted mb-0">Students enrolled in the courses you teach</p>
            </div>
            <span class="badge bg-primary fs-6 px-3 py-2" style="border-radius: 0.5rem;">
                Total: <?= $totalFiltered ?> Students
            </span>
        </div>

        <?php if (isset($db_error)): ?>
            <div class="alert alert-danger rounded-3"><i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($db_error) ?></div>
        <?php endif; ?>

        <!-- Filter Bar -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <form method="GET" class="d-flex flex-wrap gap-3 align-items-end">
                    
                    <div style="flex: 1; min-width: 150px;">
                        <label class="form-label fw-bold text-muted" style="font-size: 0.85rem;">Grade</label>
                        <select name="grade" class="form-select bg-light" onchange="this.form.submit()">
                            <option value="">All Grades</option>
                            <option value="9" <?= $f_grade == '9' ? 'selected' : '' ?>>Grade 9</option>
                            <option value="10" <?= $f_grade == '10' ? 'selected' : '' ?>>Grade 10</option>
                            <option value="11" <?= $f_grade == '11' ? 'selected' : '' ?>>Grade 11</option>
                            <option value="12" <?= $f_grade == '12' ? 'selected' : '' ?>>Grade 12</option>
                        </select>
                    </div>

                    <div style="flex: 2; min-width: 250px;">
                        <label class="form-label fw-bold text-muted" style="font-size: 0.85rem;">Search</label>
                        <input type="text" name="search" class="form-control bg-light" placeholder="Search by ID or Name..." value="<?= htmlspecialchars($f_search) ?>">
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 0.5rem;">
                            <i class="bi bi-search me-1"></i> Apply
                        </button>
                        <a href="teacherviewstudent.php" class="btn btn-outline-secondary" style="border-radius: 0.5rem;">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Students Table -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Student ID</th>
                                <th>Full Name</th>
                                <th>Sex</th>
                                <th>Phone</th>
                                <th>Grade</th>
                                <th>Section/Room</th>
                                <th>Stream</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($students)): ?>
                                <?php foreach ($students as $row): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">
                                            <?= htmlspecialchars($row['student_id']) ?>
                                        </td>
                                        <td class="fw-bold">
                                            <?= htmlspecialchars($row['firstname'] . ' ' . $row['father_name'] . ' ' . $row['grandfather_name']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['gender'] ?? '—') ?></td>
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
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-3"></i>
                                        <h5>No assigned students found</h5>
                                        <p class="mb-0">You currently have no students registered for your assigned courses.</p>
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

<?php include 'teacherfooter.php'; ?>