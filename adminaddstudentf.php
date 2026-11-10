<?php
// adminaddstudentf.php
include 'header.php'; 
$error = $_GET['error'] ?? '';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                
                <?php if($error): ?>
                    <div class="alert alert-danger rounded-3"><i class="bi bi-x-circle-fill me-2"></i><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <!-- Success Message -->
                <?php if(isset($_GET['success'])): ?>
                    <div class="alert alert-success rounded-3">
                        <h5 class="alert-heading fw-bold"><i class="bi bi-check-circle-fill me-2"></i>Student Registered Successfully!</h5>
                        <p class="mb-0">Student ID: <strong><?= htmlspecialchars($_GET['student_id'] ?? '') ?></strong></p>
                        <p class="mb-0">Default Password: <strong>student123</strong></p>
                    </div>
                <?php endif; ?>

                <form action="adminaddstudent.php" method="POST" id="studentForm" onsubmit="return validatePhone()">
                    
                    <style>
                        .blue-label { color: #3a7bd5; font-weight: 600; }
                    </style>

                    <!-- Student ID (Full Width) -->
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label blue-label">Student ID</label>
                            <input type="text" name="student_id" class="form-control bg-light" placeholder="" required>
                        </div>
                    </div>

                    <!-- Names (Two Columns) -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label blue-label">First Name</label>
                            <input type="text" name="firstname" class="form-control bg-light" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label blue-label">Father Name</label>
                            <input type="text" name="father_name" class="form-control bg-light" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label blue-label">Grandfather Name</label>
                            <input type="text" name="grandfather_name" class="form-control bg-light" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label blue-label">Age</label>
                            <input type="number" name="age" class="form-control bg-light" min="10" max="70" required>
                        </div>
                    </div>

                    <!-- Sex & Phone (Two Columns) -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label blue-label">Sex</label>
                            <select name="gender" class="form-select bg-light" required>
                                <option value="" selected disabled>Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label blue-label">Phone Number</label>
                            <input type="tel" name="phone" id="phoneInput" class="form-control bg-light" placeholder="">
                            <small id="phoneError" class="text-danger" style="display:none; font-size: 0.8rem;">Invalid format. Must start with 09 or +251.</small>
                        </div>
                    </div>

                    <!-- Academic Placement (Two Columns) -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label blue-label">Grade</label>
                            <select name="grade" id="gradeSelect" class="form-select bg-light" onchange="updateGradeLogic()" required>
                                <option value="" selected disabled>Select Grade</option>
                                <option value="9">Grade 9</option>
                                <option value="10">Grade 10</option>
                                <option value="11">Grade 11</option>
                                <option value="12">Grade 12</option>
                            </select>
                        </div>

                        <!-- Stream dropdown (Initially Hidden) -->
                        <div class="col-md-6" id="streamContainer" style="display: none;">
                            <label class="form-label blue-label">Stream</label>
                            <select name="stream" id="streamSelect" class="form-select bg-light" onchange="updateRooms()">
                                <option value="" selected disabled>Select Stream</option>
                                <option value="Natural Science">Natural Science</option>
                                <option value="Social Science">Social Science</option>
                            </select>
                        </div>
                    </div>

                    <!-- Room Dropdown (Placed below Grade/Stream for better UX) -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label blue-label">Section / Room</label>
                            <select name="section" id="roomSelect" class="form-select bg-light" required>
                                <option value="">-- First select a grade --</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.8rem; font-weight: 600;">
                            <i class="bi bi-save me-2"></i> Register Student
                        </button>
                        <a href="admindashbord.php" class="btn btn-outline-secondary" style="border-radius: 2rem; padding: 0.8rem;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Logic when Grade changes
    function updateGradeLogic() {
        const grade = document.getElementById('gradeSelect').value;
        const streamContainer = document.getElementById('streamContainer');
        const streamSelect = document.getElementById('streamSelect');
        const roomSelect = document.getElementById('roomSelect');

        // Reset Room and Stream
        roomSelect.innerHTML = '<option value="">-- Select Room --</option>';
        streamSelect.value = '';

        if (grade === '9' || grade === '10') {
            // Hide Stream
            streamContainer.style.display = 'none';
            streamSelect.required = false;

            // Populate standard rooms 1-50
            for (let i = 1; i <= 50; i++) {
                let opt = document.createElement('option');
                opt.value = "Room " + i;
                opt.textContent = "Room " + i;
                roomSelect.appendChild(opt);
            }
        } else if (grade === '11' || grade === '12') {
            // Show Stream, but wait for selection to populate rooms
            streamContainer.style.display = 'block';
            streamSelect.required = true;
            roomSelect.innerHTML = '<option value="">-- Select Stream first --</option>';
        }
    }

    // 2. Logic when Stream changes (Only for Grade 11 & 12)
    function updateRooms() {
        const grade = document.getElementById('gradeSelect').value;
        const stream = document.getElementById('streamSelect').value;
        const roomSelect = document.getElementById('roomSelect');

        if (grade === '11' || grade === '12') {
            roomSelect.innerHTML = '<option value="">-- Select Room --</option>';

            if (stream === 'Natural Science') {
                // Show N1 to N50
                for (let i = 1; i <= 50; i++) {
                    let opt = document.createElement('option');
                    opt.value = "N" + i;
                    opt.textContent = "N" + i;
                    roomSelect.appendChild(opt);
                }
            } else if (stream === 'Social Science') {
                // Show S1 to S50
                for (let i = 1; i <= 50; i++) {
                    let opt = document.createElement('option');
                    opt.value = "S" + i;
                    opt.textContent = "S" + i;
                    roomSelect.appendChild(opt);
                }
            }
        }
    }

    // Phone Validation
    function validatePhone() {
        const phoneInput = document.getElementById('phoneInput');
        const phoneError = document.getElementById('phoneError');
        const phoneValue = phoneInput.value.trim();

        if (phoneValue === '') {
            phoneError.style.display = 'none';
            return true;
        }

        const phoneRegex = /^(09\d{8}|\+251\d{9})$/;

        if (!phoneRegex.test(phoneValue)) {
            phoneError.style.display = 'block';
            phoneInput.classList.add('is-invalid');
            return false;
        }

        phoneError.style.display = 'none';
        phoneInput.classList.remove('is-invalid');
        return true;
    }

    document.getElementById('phoneInput').addEventListener('input', function() {
        document.getElementById('phoneError').style.display = 'none';
        this.classList.remove('is-invalid');
    });
</script>

<?php include 'footer.php'; ?>