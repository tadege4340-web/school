<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php
// ======================
// ADMIN CHECK
// ======================
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<p style='color:red; font-weight:bold; text-align:center;'>Only admin can update students.</p>";
    include 'footer.php';
    exit();
}

// ======================
// FETCH STUDENT FOR PREFILL (PDO)
// ======================
$student_data  = [];
$fetch_message = "";

if (isset($_POST['fetch'])) {
    $key = trim($_POST['update_key'] ?? '');
    if ($key !== '') {
        $stmt = $pdo->prepare("SELECT * FROM school2 WHERE student_id = :key LIMIT 1");
        $stmt->execute(['key' => $key]);
        $student_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student_data) {
            $fetch_message = "Student not found with that ID!";
        }
    }
}

// ======================
// HANDLE UPDATE (PDO)
// ======================
$update_message = "";
$update_type    = "success";

if (isset($_POST['update'])) {
    $old_student_id = trim($_POST['old_student_id'] ?? '');
    $new_student_id = trim($_POST['student_id'] ?? '');
    
    $firstname        = trim($_POST['firstname']        ?? '');
    $father_name      = trim($_POST['father_name']      ?? '');
    $grandfather_name = trim($_POST['grandfather_name'] ?? '');
    $new_username     = $firstname . ' ' . $father_name . ' ' . $grandfather_name;
    
    $age              = (int)($_POST['age'] ?? 0) ?: null;
    $gender           = trim($_POST['gender'] ?? ''); // ADDED GENDER
    $phone            = !empty(trim($_POST['phone'])) ? trim($_POST['phone']) : null; // HANDLE EMPTY PHONE
    
    $grade            = trim($_POST['grade']     ?? '') ?: null;
    $section          = trim($_POST['section']   ?? '') ?: null;
    $stream           = ($grade == '11' || $grade == '12') ? trim($_POST['stream'] ?? '') : 'General';

    if ($old_student_id !== '') {
        try {
            $pdo->beginTransaction();

            // Update school2
            $stmt2 = $pdo->prepare(
                "UPDATE school2
                 SET student_id = :new_sid, username = :uname, firstname = :fname, father_name = :father, grandfather_name = :gf,
                     age = :age, gender = :gender, phone = :phone, grade = :grade, section = :section, stream = :stream
                 WHERE student_id = :old_sid");
            $stmt2->execute([
                'new_sid' => $new_student_id, 'uname' => $new_username, 'fname' => $firstname, 'father' => $father_name, 'gf' => $grandfather_name,
                'age' => $age, 'gender' => $gender, 'phone' => $phone, 'grade' => $grade, 'section' => $section, 'stream' => $stream,
                'old_sid' => $old_student_id
            ]);

            // Update school1 (Login Table)
            $stmt1 = $pdo->prepare(
                "UPDATE school1
                 SET student_id = :new_sid, username = :uname, age = :age, gender = :gender, phone = :phone, grade = :grade, section = :section, stream = :stream
                 WHERE student_id = :old_sid");
            $stmt1->execute([
                'new_sid' => $new_student_id, 'uname' => $new_username, 'age' => $age, 'gender' => $gender, 'phone' => $phone, 'grade' => $grade, 'section' => $section, 'stream' => $stream,
                'old_sid' => $old_student_id
            ]);

            $pdo->commit();
            
            $update_message = "✅ Student updated successfully in both tables!";
            $update_type = "success";
            
            // Refresh displayed data
            $reload = $pdo->prepare("SELECT * FROM school2 WHERE student_id = :sid LIMIT 1");
            $reload->execute(['sid' => $new_student_id]);
            $student_data = $reload->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            
            if ($e->getCode() == 23000) {
                if (strpos($e->getMessage(), 'phone') !== false) {
                    $update_message = "❌ Update failed: This phone number is already registered to another student.";
                } else {
                    $update_message = "❌ Update failed: This Student ID already exists.";
                }
            } else {
                $update_message = "❌ Update failed: " . $e->getMessage();
            }
            $update_type = "error";
        }
    }
}

// ======================
// FETCH ALL STUDENTS (PDO)
// ======================
$result = $pdo->query("SELECT * FROM school2 ORDER BY grade ASC, section ASC");
$all_students = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Update Student</h4>
                <p class="text-muted mb-0">Search and edit student records by ID</p>
            </div>
        </div>

        <!-- FETCH FORM -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="post" class="d-flex flex-wrap gap-3 align-items-end">
                    <div class="flex-grow-1" style="max-width: 400px;">
                        <label class="form-label fw-bold" style="color: #3a7bd5;">Enter Student ID to Edit:</label>
                        <input type="text" name="update_key" class="form-control bg-light"
                               value="<?= htmlspecialchars($_POST['update_key'] ?? '') ?>"
                               placeholder="e.g. STU-2026-001" required>
                    </div>
                    <button type="submit" name="fetch" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.6rem 2rem;">
                        <i class="bi bi-search me-2"></i> Load Student
                    </button>
                </form>
            </div>
        </div>

        <!-- Messages -->
        <?php if ($fetch_message !== ''): ?>
            <div class="alert alert-danger rounded-3"><i class="bi bi-x-circle-fill me-2"></i><?= htmlspecialchars($fetch_message) ?></div>
        <?php endif; ?>

        <?php if ($update_message !== ''): ?>
            <div class="alert alert-<?= $update_type === 'success' ? 'success' : 'danger' ?> rounded-3">
                <?= htmlspecialchars($update_message) ?>
            </div>
        <?php endif; ?>

        <!-- UPDATE FORM -->
        <?php if (!empty($student_data)): ?>
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="fw-bold mb-0">Edit ID: <?= htmlspecialchars($student_data['student_id']) ?></h5>
            </div>
            <div class="card-body p-4">
                <form method="post">
                    <input type="hidden" name="old_student_id" value="<?= htmlspecialchars($student_data['student_id']) ?>">

                    <h6 class="text-primary fw-bold mb-3">Personal Info</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="color:#3a7bd5;">Student ID</label>
                            <input type="text" name="student_id" class="form-control bg-light" value="<?= htmlspecialchars($student_data['student_id'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="color:#3a7bd5;">Age</label>
                            <input type="number" name="age" class="form-control bg-light" min="10" max="70" value="<?= htmlspecialchars($student_data['age'] ?? '') ?>">
                        </div>
                        <!-- ADDED SEX FIELD -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="color:#3a7bd5;">Sex</label>
                            <select name="gender" class="form-select bg-light" required>
                                <option value="Male" <?= ($student_data['gender'] ?? '') == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= ($student_data['gender'] ?? '') == 'Female' ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="color:#3a7bd5;">First Name</label>
                            <input type="text" name="firstname" class="form-control bg-light" value="<?= htmlspecialchars($student_data['firstname'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="color:#3a7bd5;">Father Name</label>
                            <input type="text" name="father_name" class="form-control bg-light" value="<?= htmlspecialchars($student_data['father_name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="color:#3a7bd5;">Grandfather Name</label>
                            <input type="text" name="grandfather_name" class="form-control bg-light" value="<?= htmlspecialchars($student_data['grandfather_name'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="color:#3a7bd5;">Phone Number</label>
                            <input type="tel" name="phone" class="form-control bg-light" value="<?= htmlspecialchars($student_data['phone'] ?? '') ?>" placeholder="09... or +251...">
                        </div>
                    </div>

                    <h6 class="text-primary fw-bold mb-3 mt-4">Academic Placement</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="color:#3a7bd5;">Grade</label>
                            <select name="grade" id="gradeSelect" class="form-select bg-light" onchange="updateRooms()" required>
                                <option value="9" <?= $student_data['grade'] == '9' ? 'selected' : '' ?>>Grade 9</option>
                                <option value="10" <?= $student_data['grade'] == '10' ? 'selected' : '' ?>>Grade 10</option>
                                <option value="11" <?= $student_data['grade'] == '11' ? 'selected' : '' ?>>Grade 11</option>
                                <option value="12" <?= $student_data['grade'] == '12' ? 'selected' : '' ?>>Grade 12</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="color:#3a7bd5;">Section / Room</label>
                            <select name="section" id="roomSelect" class="form-select bg-light" required>
                                <!-- Options filled by JS -->
                            </select>
                        </div>

                        <div class="col-md-4" id="streamContainer" style="<?= ($student_data['grade'] == '11' || $student_data['grade'] == '12') ? '' : 'display: none;' ?>">
                            <label class="form-label fw-bold" style="color:#3a7bd5;">Stream</label>
                            <select name="stream" id="streamSelect" class="form-select bg-light" <?= ($student_data['grade'] == '11' || $student_data['grade'] == '12') ? 'required' : '' ?>>
                                <option value="Natural Science" <?= $student_data['stream'] == 'Natural Science' ? 'selected' : '' ?>>Natural Science</option>
                                <option value="Social Science" <?= $student_data['stream'] == 'Social Science' ? 'selected' : '' ?>>Social Science</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" name="update" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.6rem 2rem;" onclick="return confirm('Save changes?');">
                            <i class="bi bi-save me-2"></i> Update Student
                        </button>
                        <a href="adminupdatestudent.php" class="btn btn-outline-secondary" style="border-radius: 2rem; padding: 0.6rem 2rem;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- ALL STUDENTS TABLE -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="fw-bold mb-0">All Students</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Student ID</th>
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Grade</th>
                                <th>Room</th>
                                <th>Stream</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($all_students)): ?>
                                <?php foreach ($all_students as $row): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary"><?= htmlspecialchars($row['student_id'] ?? '—') ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($row['username']) ?></td>
                                        <td><?= htmlspecialchars($row['age'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($row['gender'] ?? '—') ?></td>
                                        <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle">Grade <?= htmlspecialchars($row['grade']) ?></span></td>
                                        <td><?= htmlspecialchars($row['section'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($row['stream'] ?? '—') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="text-center py-4 text-muted">No students found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- JavaScript to handle Rooms/Streams -->
<script>
    function updateRooms() {
        const grade = document.getElementById('gradeSelect').value;
        const roomSelect = document.getElementById('roomSelect');
        const streamContainer = document.getElementById('streamContainer');
        const streamSelect = document.getElementById('streamSelect');
        
        const currentRoom = roomSelect.value || "<?= $student_data['section'] ?? '' ?>";
        
        roomSelect.innerHTML = '<option value="">-- Select Room --</option>';

        if (grade === '9' || grade === '10') {
            for (let i = 1; i <= 50; i++) {
                let opt = document.createElement('option');
                opt.value = "Room " + i;
                opt.textContent = "Room " + i;
                if(opt.value === currentRoom) opt.selected = true;
                roomSelect.appendChild(opt);
            }
            streamContainer.style.display = 'none';
            streamSelect.required = false;
        } else if (grade === '11' || grade === '12') {
            let groupN = document.createElement('optgroup'); groupN.label = "Natural Science Rooms";
            for (let i = 1; i <= 50; i++) {
                let opt = document.createElement('option'); opt.value = "N" + i; opt.textContent = "N" + i + " (Natural)"; 
                if(opt.value === currentRoom) opt.selected = true;
                groupN.appendChild(opt);
            }
            roomSelect.appendChild(groupN);

            let groupS = document.createElement('optgroup'); groupS.label = "Social Science Rooms";
            for (let i = 1; i <= 50; i++) {
                let opt = document.createElement('option'); opt.value = "S" + i; opt.textContent = "S" + i + " (Social)"; 
                if(opt.value === currentRoom) opt.selected = true;
                groupS.appendChild(opt);
            }
            roomSelect.appendChild(groupS);

            streamContainer.style.display = 'block';
            streamSelect.required = true;
        }
    }

    // Run on page load if student data is loaded
    document.addEventListener('DOMContentLoaded', function() {
        if(document.getElementById('gradeSelect')) {
            updateRooms();
        }
    });
</script>

<?php include 'footer.php'; ?>