<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login • EduSphere Academy</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="school.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="school.php">
                <i class="bi bi-mortarboard-fill me-2"></i>EduSphere
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Login Content -->
    <div class="container flex-grow-1 d-flex align-items-center justify-content-center py-5">
        <div class="login-box w-100" style="max-width: 420px; background: #fff; padding: 2.5rem; border-radius: 1.5rem; box-shadow: 0 15px 35px rgba(0,0,0,0.08);">
            
            <div class="text-center mb-4">
                <i class="bi bi-person-circle text-primary" style="font-size: 3rem;"></i>
                <h3 class="fw-bold mt-2"></h3>
                <p class="text-muted">Please login to your account</p>
            </div>

            <!-- PHP Error Messages -->
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger py-2 text-center" style="border-radius: 0.8rem; font-size: 0.9rem;">
                    <?php
                        $err = $_GET['error'];
                        if ($err === 'wrongpass')             echo "<i class='bi bi-x-circle-fill me-1'></i> Incorrect password. Try again.";
                        elseif ($err === 'nousername')        echo "<i class='bi bi-x-circle-fill me-1'></i> Student ID not found.";
                        elseif ($err === 'emptyfields')       echo "<i class='bi bi-x-circle-fill me-1'></i> Please fill in all fields.";
                        elseif ($err === 'servererror')       echo "<i class='bi bi-x-circle-fill me-1'></i> Server error. Try again later.";
                        else                                  echo "<i class='bi bi-x-circle-fill me-1'></i> Login failed. Please try again.";
                    ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" id="loginForm">
                <!-- Username / Student ID -->
                <div class="mb-3">
                    <label for="username" class="form-label fw-bold"> Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="" required autofocus style="border-radius: 0.8rem; padding: 0.8rem;">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="" required style="border-radius: 0.8rem 0 0 0.8rem; padding: 0.8rem;">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password', this)" aria-label="Show password" style="border-radius: 0 0.8rem 0.8rem 0; border-color: #ced4da;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Login -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" id="remember" name="remember" value="1" class="form-check-input">
                        <label for="remember" class="form-check-label text-muted">Remember me</label>
                    </div>
                    <a href="#" class="text-decoration-none" style="font-size: 0.9rem;">Forgot password?</a>
                </div>

                <!-- Buttons -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary w-100" style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.8rem; font-weight: 600;">Login</button>
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="resetForm()" style="border-radius: 2rem; padding: 0.8rem;">Cancel</button>
                </div>
            </form>
            
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-auto">
        <div class="container">
            <h4 class="text-white mb-3">EduSphere Academy</h4>
            <p>&copy; 2026 EduSphere. All rights reserved.</p>
            <p>Designed with <i class="bi bi-heart-fill" style="color:#e74c3c;"></i> by Tadege Yilkal</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JAVASCRIPT (Only for toggling password and resetting form) -->
    <script>
    function togglePassword(fieldId, button) {
        const field = document.getElementById(fieldId);
        const icon = button.querySelector('i');
        if (!field) return;

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    function resetForm() {
        document.getElementById('loginForm').reset();
        document.getElementById('username').focus();
        
        const field = document.getElementById('password');
        const icon = document.querySelector('.input-group button i');
        if (field.type === 'text') {
            field.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
    </script>

</body>
</html>