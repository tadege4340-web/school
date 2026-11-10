<?php
// teacherviewcoursef.php - Frontend UI
include 'teacherheader.php'; 
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-journal-bookmark-fill me-2"></i>My Assigned Courses</h4>
                <p class="text-muted mb-0">Subjects you are currently teaching for Grades 9 - 12</p>
            </div>
            <span class="badge bg-primary fs-6 px-3 py-2" style="border-radius: 0.5rem;">
                Total: <?= count($my_courses) ?> Courses
            </span>
        </div>

        <?php if (isset($db_error)): ?>
            <div class="alert alert-danger rounded-3"><i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($db_error) ?></div>
        <?php endif; ?>

        <!-- Courses Grid -->
        <?php if (empty($my_courses)): ?>
            <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                <div class="card-body">
                    <i class="bi bi-journal-x fs-1 text-muted mb-3 d-block"></i>
                    <h5 class="fw-bold">No Courses Assigned</h5>
                    <p class="text-muted mb-0">You currently do not have any courses assigned to you by the Admin.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($my_courses as $c): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <!-- Course Code -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge bg-primary px-3 py-2" style="font-size: 0.9rem; border-radius: 0.5rem;">
                                        <?= htmlspecialchars($c['course_code']) ?>
                                    </span>
                                    <i class="bi bi-book text-primary fs-3"></i>
                                </div>
                                
                                <!-- Course Name -->
                                <h5 class="fw-bold mb-3"><?= htmlspecialchars($c['course_name']) ?></h5>
                                
                                <!-- Course Meta (Grade & Stream) -->
                                <div class="d-flex flex-wrap gap-2 mt-auto">
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-layers me-1"></i> Grade <?= htmlspecialchars($c['grade']) ?>
                                    </span>
                                    
                                    <?php if ($c['stream'] == 'General' || empty($c['stream'])): ?>
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-diagram-3 me-1"></i> General
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle">
                                            <i class="bi bi-diagram-3 me-1"></i> <?= htmlspecialchars($c['stream']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include 'teacherfooter.php'; ?>