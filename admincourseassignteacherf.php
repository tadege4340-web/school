<?php
// admincourseassignteacherf.php - Frontend UI
include 'header.php'; 
require 'admincourseassignteacher.php'; 
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-person-video3 me-2"></i>Assign Courses to Teachers</h4>
                <p class="text-muted mb-0">Bulk assign subjects to teachers based on Grade and Stream</p>
            </div>
        </div>

        <?php if($message): ?>
            <div class="alert alert-<?= $message_type ?> rounded-3">
                <i class="bi bi-<?= $message_type === 'success' ? 'check-circle-fill' : 'x-circle-fill' ?> me-2"></i>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Step 1: Filter -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET" class="d-flex flex-wrap gap-3 align-items-end">
                    
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label fw-bold" style="color: #3a7bd5;">Select Grade</label>
                        <select name="grade" class="form-select bg-light" required onchange="this.form.submit()">
                            <option value="">-- Choose Grade --</option>
                            <option value="9" <?= $filter_grade == '9' ? 'selected' : '' ?>>Grade 9</option>
                            <option value="10" <?= $filter_grade == '10' ? 'selected' : '' ?>>Grade 10</option>
                            <option value="11" <?= $filter_grade == '11' ? 'selected' : '' ?>>Grade 11</option>
                            <option value="12" <?= $filter_grade == '12' ? 'selected' : '' ?>>Grade 12</option>
                        </select>
                    </div>

                    <div style="flex: 1; min-width: 200px;" id="streamFilterContainer" class="<?= ($filter_grade == '11' || $filter_grade == '12') ? '' : 'd-none' ?>">
                        <label class="form-label fw-bold" style="color: #3a7bd5;">Select Stream</label>
                        <select name="stream" class="form-select bg-light" onchange="this.form.submit()">
                            <option value="">-- Choose Stream --</option>
                            <option value="Natural Science" <?= $filter_stream == 'Natural Science' ? 'selected' : '' ?>>Natural Science</option>
                            <option value="Social Science" <?= $filter_stream == 'Social Science' ? 'selected' : '' ?>>Social Science</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.6rem 2rem;">
                        <i class="bi bi-search me-2"></i> Load Data
                    </button>
                </form>
            </div>
        </div>

        <!-- Step 2: Assign -->
        <?php if ($filter_grade !== '' && (($filter_grade == '9' || $filter_grade == '10') || $filter_stream !== '')): ?>
            <form method="POST">
                <input type="hidden" name="current_grade" value="<?= htmlspecialchars($filter_grade) ?>">
                <input type="hidden" name="current_stream" value="<?= htmlspecialchars($filter_stream) ?>">
                
                <div class="row g-4 mb-4">
                    <!-- Teachers List -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-person-badge-fill me-2"></i>Teachers (<?= count($teachers) ?>)</h5>
                            </div>
                            <div class="card-body p-3">
                                <select multiple id="teacherList" name="teacher_ids[]" class="form-select bg-light" style="height: 300px; padding: 10px;">
                                    <?php foreach ($teachers as $t): ?>
                                        <option value="<?= htmlspecialchars($t['teacher_id']) ?>" selected>
                                            <?= htmlspecialchars($t['teacher_id'] . ' - ' . $t['full_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted mt-2 d-block">Hold Ctrl (Windows) or Cmd (Mac) to select multiple teachers.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Courses List -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0 text-success"><i class="bi bi-journal-bookmark-fill me-2"></i>Courses (<?= count($courses) ?>)</h5>
                                <span class="badge bg-success">Grade <?= $filter_grade ?> <?= $filter_stream ?></span>
                            </div>
                            <div class="card-body p-3">
                                <select multiple id="courseList" name="course_codes[]" class="form-select bg-light" style="height: 300px; padding: 10px;">
                                    <?php foreach ($courses as $c): ?>
                                        <option value="<?= htmlspecialchars($c['course_code']) ?>">
                                            <?= htmlspecialchars($c['course_code'] . ' - ' . $c['course_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted mt-2 d-block">Hold Ctrl (Windows) or Cmd (Mac) to select multiple courses.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" name="assign" class="btn btn-primary btn-lg" style="background-color: var(--primary-color); border-radius: 2rem; padding: 1rem 3rem; font-weight: 600;" onclick="return confirm('Are you sure you want to assign these courses to the selected teachers?');">
                        <i class="bi bi-check2-circle me-2"></i> Assign Courses Now
                    </button>
                </div>
            </form>
        <?php else: ?>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center py-5 text-muted">
                    <i class="bi bi-arrow-up-circle fs-1 d-block mb-3"></i>
                    <h5>Select a Grade to Begin</h5>
                    <p>Choose a Grade from the dropdown above. If it's Grade 11 or 12, also select the Stream.</p>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
    // Dynamically show/hide Stream filter based on Grade selection
    document.querySelector('select[name="grade"]').addEventListener('change', function() {
        const streamContainer = document.getElementById('streamFilterContainer');
        if (this.value === '11' || this.value === '12') {
            streamContainer.classList.remove('d-none');
        } else {
            streamContainer.classList.add('d-none');
            streamContainer.querySelector('select').value = ''; // Reset stream
        }
    });
</script>

<?php include 'footer.php'; ?>