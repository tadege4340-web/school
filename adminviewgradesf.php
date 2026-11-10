<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-bar-chart-fill me-2"></i>Student Grades</h4>
                <p class="text-muted mb-0">View all exam results for Grades 9 - 12</p>
            </div>
            <div class="badge bg-primary fs-5 px-4 py-2" style="border-radius: 1rem;">
                Total Records: <?= $total_rows ?>
            </div>
        </div>

        <!-- Filters -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <form method="GET" class="d-flex flex-wrap gap-3 align-items-center">
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control bg-light border-start-0" placeholder="Search by ID or Name..." value="<?= htmlspecialchars($search) ?>">
                    </div>
                    
                    <select name="grade" class="form-select bg-light" style="max-width: 200px;">
                        <option value="">All Grades</option>
                        <option value="9" <?= $filter_grade == '9' ? 'selected' : '' ?>>Grade 9</option>
                        <option value="10" <?= $filter_grade == '10' ? 'selected' : '' ?>>Grade 10</option>
                        <option value="11" <?= $filter_grade == '11' ? 'selected' : '' ?>>Grade 11</option>
                        <option value="12" <?= $filter_grade == '12' ? 'selected' : '' ?>>Grade 12</option>
                    </select>

                    <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.5rem 1.5rem;">Filter</button>
                    <a href="adminviewgrades.php" class="btn btn-outline-secondary" style="border-radius: 2rem; padding: 0.5rem 1.5rem;">Clear</a>
                </form>
            </div>
        </div>

        <!-- Grades Table -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Student</th>
                                <th>Grade & Room</th>
                                <th>Subject</th>
                                <th>Marks</th>
                                <th>Total</th>
                                <th>Percentage</th>
                                <th>Letter Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($grades)): ?>
                                <?php foreach ($grades as $row): ?>
                                    <?php 
                                        // Calculate Percentage
                                        $percent = ($row['total_marks'] > 0) ? ($row['marks_obtained'] / $row['total_marks']) * 100 : 0;
                                        $percent = round($percent, 1);
                                        list($letter, $color) = getLetterGrade($percent);
                                    ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold"><?= htmlspecialchars($row['firstname'] . ' ' . $row['father_name']) ?></div>
                                            <small class="text-muted">ID: <?= htmlspecialchars($row['student_id']) ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                Grade <?= htmlspecialchars($row['grade']) ?>
                                            </span>
                                            <small class="d-block mt-1"><?= htmlspecialchars($row['section']) ?></small>
                                        </td>
                                        <td class="fw-bold"><?= htmlspecialchars($row['subject']) ?></td>
                                        <td><?= htmlspecialchars($row['marks_obtained']) ?></td>
                                        <td><?= htmlspecialchars($row['total_marks']) ?></td>
                                        <td>
                                            <div class="progress" style="height: 8px; width: 100px;">
                                                <div class="progress-bar bg-<?= $color ?>" role="progressbar" style="width: <?= $percent ?>%"></div>
                                            </div>
                                            <small class="fw-bold mt-1"><?= $percent ?>%</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?= $color ?> fs-6" style="border-radius: 0.5rem;">
                                                <?= $letter ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-journal-x fs-1 d-block mb-3"></i>
                                        No grade records found.
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