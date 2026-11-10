<?php
// contactus.php - Standalone Contact Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>Contact Us • EduSphere Academy</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- YOUR SEPARATE CSS FILE -->
    <link rel="stylesheet" href="school.css">
</head>
<body>

    <!-- Navigation Bar (Matching the rest of the site) -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="school.php">
                <i class="bi bi-mortarboard-fill me-2"></i>EduSphere
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="school.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="news.php">News</a></li>
                    <!-- Active Link for Contact Us -->
                    <li class="nav-item"><a class="nav-link active" href="contactus.php">Contact Us</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light rounded-pill px-4" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ================= CONTACT SECTION ================= -->
    <main class="container py-5 mt-4">
        
        <!-- Contact Header -->
        <div class="contact-header">
            <h1>
                <i class="bi bi-person-lines-fill text-primary"></i> 
                Contact Tadege
            </h1>
            <div class="subhead">Let’s connect – call, email, or reach out on social media</div>
        </div>

        <!-- Contact Grid -->
        <div class="contact-grid">
            
            <!-- 1. Primary Phone -->
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="bi bi-telephone-fill"></i>
                </div>
                <div class="contact-detail">
                    <span class="contact-label">Primary Phone</span>
                    <span class="contact-value">
                        <a href="tel:0928293370">0928293370</a>
                    </span>
                </div>
            </div>

            <!-- 2. Secondary Phone -->
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="bi bi-phone-fill"></i>
                </div>
                <div class="contact-detail">
                    <span class="contact-label">Secondary Phone</span>
                    <span class="contact-value">
                        <a href="tel:0918169491">0918169491</a>
                    </span>
                </div>
            </div>

            <!-- 3. Primary Email (Opens Gmail) -->
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="bi bi-envelope-fill"></i>
                </div>
                <div class="contact-detail">
                    <span class="contact-label">Primary Email</span>
                    <span class="contact-value">
                        <!-- Changed to open Gmail in a new tab -->
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=tadege4340@gmail.com" target="_blank">tadege4340@gmail.com</a>
                    </span>
                </div>
            </div>

            <!-- 4. Secondary Email (Opens Gmail) -->
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="bi bi-envelope-open-fill"></i>
                </div>
                <div class="contact-detail">
                    <span class="contact-label">Secondary Email</span>
                    <span class="contact-value">
                        <!-- Changed to open Gmail in a new tab -->
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=tadegeyilkal@gmail.com" target="_blank">tadegeyilkal@gmail.com</a>
                    </span>
                </div>
            </div>

            <!-- 5. Telegram -->
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="bi bi-telegram"></i>
                </div>
                <div class="contact-detail">
                    <span class="contact-label">Telegram</span>
                    <span class="contact-value">
                        <a href="https://t.me/tadege2123" target="_blank">@tadege2123</a>
                    </span>
                </div>
            </div>

            <!-- 6. Facebook -->
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="bi bi-facebook"></i>
                </div>
                <div class="contact-detail">
                    <span class="contact-label">Facebook</span>
                    <span class="contact-value">
                        <a href="https://facebook.com/tadegeyilkal" target="_blank">Tadege Yilkal</a>
                    </span>
                </div>
            </div>

        </div>

        <!-- Contact Footer -->
        <div class="contact-footer">
            <i class="bi bi-heart-fill"></i> 
            <span>Reach out anytime — I’ll respond as soon as I can.</span>
            <i class="bi bi-heart-fill"></i>
        </div>

    </main>

   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// footer.php
?>
        </div> <!-- Close content-wrapper -->
    </div> <!-- Close main-content -->

    <!-- Include the Universal Footer -->
    <?php include 'footerall.php'; ?>