<?php
// adminaddcoursef.php
include 'header.php'; 
require 'db.php';

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                
                <?php if($error): ?>
                    <div class="alert alert-danger rounded-3"><i class="bi bi-x-circle-fill me-2"></i><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success rounded-3">
                        <h5 class="alert-heading fw-bold"><i class="bi bi-check-circle-fill me-2"></i>Course Added Successfully!</h5>
                    </div>
                <?php endif; ?>

                <form action="adminaddcourse.php" method="POST">
                    
                    <style>
                        .blue-label { color: #3a7bd5; font-weight: 600; }
                    </style>

                    <h6 class="text-primary fw-bold mb-3">ADD Course</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label blue-label">Course Name</label>
                            <input type="text" name="course_name" class="form-control bg-light" placeholder="" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label blue-label">Course Code (Optional)</label>
                            <input type="text" name="course_code" class="form-control bg-light" placeholder="">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label blue-label">Grade</label>
                            <select name="grade" id="gradeSelect" class="form-select bg-light" onchange="updateStream()" required>
                                <option value="" selected disabled>Select Grade</option>
                                <option value="9">Grade 9</option>
                                <option value="10">Grade 10</option>
                                <option value="11">Grade 11</option>
                                <option value="12">Grade 12</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="streamContainer" style="display: none;">
                            <label class="form-label blue-label">Stream</label>
                            <select name="stream" id="streamSelect" class="form-select bg-light">
                                <option value="" selected disabled>Select Stream</option>
                                <option value="Natural Science">Natural Science</option>
                                <option value="Social Science">Social Science</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.8rem; font-weight: 600;">
                            <i class="bi bi-save me-2"></i> Save Course
                        </button>
                        <a href="admindashbord.php" class="btn btn-outline-secondary" style="border-radius: 2rem; padding: 0.8rem;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Show Stream dropdown only for Grade 11 & 12
    function updateStream() {
        const grade = document.getElementById('gradeSelect').value;
        const streamContainer = document.getElementById('streamContainer');
        const streamSelect = document.getElementById('streamSelect');

        if (grade === '11' || grade === '12') {
            streamContainer.style.display = 'block';
            streamSelect.required = true;
        } else {
            streamContainer.style.display = 'none';
            streamSelect.required = false;
            streamSelect.value = '';
        }
    }
</script>

<?php include 'footer.php'; ?>