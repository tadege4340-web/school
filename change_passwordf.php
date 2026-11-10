<?php
// change_passwordf.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password • EduSphere</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="admindashbord.css">
    
    <style>
        body {
            background-color: #f4f6fb;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .password-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
        }
    </style>
</head>
<body>

    <div class="password-card">
        
        <div class="text-center mb-4">
            <i class="bi bi-shield-lock-fill text-primary" style="font-size: 3rem;"></i>
            <h3 class="fw-bold mt-3">Change Password</h3>
            <p class="text-muted">For security reasons, you must change your default password before continuing.</p>
        </div>

        <?php if ($message !== ''): ?>
            <div class="alert alert-<?= $message_type === 'error' ? 'danger' : 'success' ?> rounded-3 text-center">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            
            <div class="alert alert-info rounded-3 text-center mb-4" style="font-size: 0.9rem;">
                Logged in as: <strong><?= htmlspecialchars($username) ?></strong>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">New Password</label>
                <input type="password" name="new_password" class="form-control bg-light" required minlength="7" placeholder="Enter new password (min 7 chars)">
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control bg-light" required minlength="7" placeholder="Confirm new password">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color); border-radius: 2rem; padding: 0.8rem; font-weight: 600;">
                    <i class="bi bi-save me-2"></i> Save New Password
                </button>
                <a href="logout.php" class="btn btn-outline-secondary" style="border-radius: 2rem; padding: 0.8rem;">
                    Cancel & Logout
                </a>
            </div>
        </form>
    </div>

</body>
</html>