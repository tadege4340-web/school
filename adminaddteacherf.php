<?php
// adminaddteacherf.php
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
                
                <?php if(isset($_GET['success'])): ?>
                    <div class="alert alert-success rounded-3">
                        <h5 class="alert-heading fw-bold"><i class="bi bi-check-circle-fill me-2"></i>Teacher Registered Successfully!</h5>
                        <p class="mb-0">Teacher ID: <strong><?= htmlspecialchars($_GET['teacher_id'] ?? '') ?></strong></p>
                        <p class="mb-0">Default Password: <strong>teacher123</strong></p>
                    </div>
                <?php endif; ?>

                <form action="adminaddteacher.php" method="POST" onsubmit="return validatePhone()">
                    
                    <style>
                        .blue-label { color: #3a7bd5; font-weight: 600; }
                    </style>

                    <!-- IDs & Name (Full Width) -->
                    <h6 class="text-primary fw-bold mb-3"> ADD Teacher </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label blue-label">Teacher ID</label>
                            <input type="text" name="teacher_id" class="form-control bg-light" placeholder="" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label blue-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control bg-light" placeholder="" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label blue-label">Age</label>
                            <input type="number" name="age" class="form-control bg-light" min="18" max="80" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label blue-label">Sex</label>
                            <select name="gender" class="form-select bg-light" required>
                                <option value="" selected disabled>Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label blue-label">Phone Number</label>
                            <input type="tel" name="phone" id="phoneInput" class="form-control bg-light" placeholder="">
                            <small id="phoneError" class="text-danger" style="display:none; font-size: 0.8rem;">Invalid format. Must start with 09 or +251.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label blue-label">Address</label>
                            <input type="text" name="address" class="form-control bg-light" placeholder="">
                        </div>
                    </div>

                    <!-- Academic Info -->

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label blue-label">Qualification</label>
                            <select name="qualification" class="form-select bg-light">
                                <option value="">-- Select Qualification --</option>
                                <option value="BSc">BSc</option>
                                <option value="BA">BA</option>
                                <option value="MSc">MSc</option>
                                <option value="MA">MA</option>
                                <option value="PhD">PhD</option>
                                <option value="Diploma">Diploma</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label blue-label">Position</label>
                            <select name="position" class="form-select bg-light">
                                <option value="">-- Select Position --</option>
                                <option value="Teacher">Teacher</option>
                                <option value="Senior Teacher">Senior Teacher</option>
                                <option value="Department Head">Department Head</option>
                                <option value="Vice Principal">Vice Principal</option>
                                <option value="Principal">Principal</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label blue-label">Hire Date</label>
                            <input type="date" name="hire_date" class="form-control bg-light">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label blue-label">Status</label>
                            <select name="status" class="form-select bg-light">
                                <option value="Active">Active</option>
                                <option value="On Leave">On Leave</option>
                                <option value="Retired">Retired</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.8rem; font-weight: 600;">
                            <i class="bi bi-save me-2"></i> Register Teacher
                        </button>
                        <a href="admindashbord.php" class="btn btn-outline-secondary" style="border-radius: 2rem; padding: 0.8rem;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
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