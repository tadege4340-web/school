<?php
// school.php - Single Page Application (Home, Info)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSphere - Secondary School Management</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- YOUR SEPARATE CSS FILE -->
    <link rel="stylesheet" href="school.css">
    
    <!-- Custom styles for the new sections -->
    <style>
        .info-section { background: #fff; border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 2rem; height: 100%; }
        .info-title { color: #0b1e33; font-weight: 700; border-bottom: 3px solid #3a7bd5; padding-bottom: 10px; margin-bottom: 20px; display: inline-block; }
        .list-group-custom .list-group-item { border: none; border-bottom: 1px solid #f1f5f9; padding: 12px 0; background: transparent; }
        .list-group-custom .list-group-item:last-child { border-bottom: none; }
        .table-custom th { background-color: #0b1e33; color: white; font-weight: 500; }
        .table-custom td { vertical-align: middle; }
        .login-guide-box { background: #f8fafc; border-left: 5px solid #3a7bd5; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem; }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#" onclick="showPage('home')">
                <i class="bi bi-mortarboard-fill me-2"></i>EduSphere
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" id="link-home" onclick="showPage('home')">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="link-info" onclick="showPage('info')">School Info & Login Guide</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contactus.php">Contact Us</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light rounded-pill px-4" href="loginf.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ================= 1. HOME SECTION ================= -->
    <div id="section-home">
        <header class="hero">
            <div class="container">
                <h1>Welcome to EduSphere Academy</h1>
                <p>Empowering students from Grade 9 to Grade 12 with the knowledge and skills to shape the future.</p>
                <a href="#features" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary">Explore Programs</a>
            </div>
        </header>

        <section id="features" class="py-5">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Why Choose Us?</h2>
                    <p class="text-muted">We provide the best environment for learning and growth.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card text-center">
                            <i class="bi bi-book-half feature-icon"></i>
                            <h4>Modern Curriculum</h4>
                            <p class="text-muted">Tailored for Grades 9-12, focusing on Natural and Social Science streams.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card text-center">
                            <i class="bi bi-people-fill feature-icon"></i>
                            <h4>Expert Teachers</h4>
                            <p class="text-muted">Our faculty consists of highly qualified and dedicated educators.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card text-center">
                            <i class="bi bi-laptop feature-icon"></i>
                            <h4>Smart Classrooms</h4>
                            <p class="text-muted">Equipped with the latest technology to enhance the learning experience.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- ================= 2. INFO & LOGIN GUIDE SECTION ================= -->
    <div id="section-info" style="display: none;">
        <div class="container py-5 mt-4">
            
            <!-- Intro -->
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Secondary School Information System</h2>
                <p class="text-muted fs-5">Manage academic records, courses, and grades for Grades 9 through 12.</p>
            </div>

            <div class="row g-4">
                <!-- Left Column: Academic Structure -->
                <div class="col-lg-6">
                    <div class="info-section">
                        <h4 class="info-title"><i class="bi bi-building me-2"></i>Academic Structure</h4>
                        
                        <h6 class="fw-bold mt-4 text-dark">📚 Grade Levels & Streams</h6>
                        <ul class="list-group list-group-custom">
                            <li class="list-group-item"><i class="bi bi-check2-circle text-primary me-2"></i><strong>Grade 9 & 10:</strong> General Secondary Education</li>
                            <li class="list-group-item"><i class="bi bi-check2-circle text-primary me-2"></i><strong>Grade 11 & 12:</strong> Natural Science Stream</li>
                            <li class="list-group-item"><i class="bi bi-check2-circle text-primary me-2"></i><strong>Grade 11 & 12:</strong> Social Science Stream</li>
                        </ul>

                        <h6 class="fw-bold mt-4 text-dark">📖 Core Subjects</h6>
                        <ul class="list-group list-group-custom">
                            <li class="list-group-item"><i class="bi bi-dot text-secondary"></i>Mathematics</li>
                            <li class="list-group-item"><i class="bi bi-dot text-secondary"></i>English</li>
                            <li class="list-group-item"><i class="bi bi-dot text-secondary"></i>Physics</li>
                            <li class="list-group-item"><i class="bi bi-dot text-secondary"></i>Chemistry</li>
                            <li class="list-group-item"><i class="bi bi-dot text-secondary"></i>Biology</li>
                            <li class="list-group-item"><i class="bi bi-dot text-secondary"></i>History</li>
                            <li class="list-group-item"><i class="bi bi-dot text-secondary"></i>Geography</li>
                            <li class="list-group-item"><i class="bi bi-dot text-secondary"></i>Civics</li>
                        </ul>
                    </div>
                </div>

                <!-- Right Column: Login Guide -->
                <div class="col-lg-6">
                    <div class="info-section">
                        <h4 class="info-title"><i class="bi bi-shield-lock-fill me-2"></i>Student Login Guide</h4>
                        
                        <div class="login-guide-box">
                            <p class="text-muted mb-2">
                                To view your academic details, you must first login. The login link is located in the top navigation bar.
                            </p>
                            <p class="text-muted mb-2">
                                When the login screen is displayed, enter your <strong>Student ID</strong> as the username and your <strong>Default Password</strong> as the initial password.
                            </p>
                            <p class="text-danger small fw-bold mb-0">
                                ⚠️ Important: Upon first login, you will be required to change your temporary password. The new password must be at least 7 characters long.
                            </p>
                        </div>

                        <h6 class="fw-bold mb-3">Example Accounts</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-custom rounded-3">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Username (ID)</th>
                                        <th>Temporary Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Amanuel Aman</td>
                                        <td><span class="badge bg-primary">3232</span></td>
                                        <td><code class="text-danger fw-bold">student123</code></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Demeke Tadele</td>
                                        <td><span class="badge bg-primary">1501088</span></td>
                                        <td><code class="text-danger fw-bold">student123</code></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Bereberew Gudie</td>
                                        <td><span class="badge bg-primary">13333</span></td>
                                        <td><code class="text-danger fw-bold">student123</code></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="loginf.php" class="btn btn-primary px-4 py-2 rounded-pill fw-bold" style="background-color: #0b1e33;">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Go to Login Page
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= PROFESSIONAL FOOTER ================= -->
    <footer class="site-footer mt-0">
        <div class="container footer-container">
            
            <div class="row g-4">
                <!-- Column 1: About -->
                <div class="col-lg-4 col-md-6">
                    <h3>EDUSPHERE ACADEMY</h3>
                    <p class="footer-desc">
                        Student Information Management System (SIMS) — A secure, centralized platform for managing academic records, courses, and student data efficiently.
                    </p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" aria-label="Telegram"><i class="bi bi-telegram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="#" aria-label="Email"><i class="bi bi-envelope-fill"></i></a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h3>QUICK LINKS</h3>
                    <ul class="footer-links">
                        <li><a href="school.php">Home</a></li>
                        <li><a href="contactus.php">Contact Us</a></li>
                        <li><a href="#" onclick="showPage('info')">School Info</a></li>
                        <li><a href="loginf.php">Student Login</a></li>
                    </ul>
                </div>

                <!-- Column 3: Contact Info -->
                <div class="col-lg-3 col-md-6">
                    <h3>CONTACT US</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="bi bi-geo-alt-fill"></i> 
                            <span>Injibara, Awi Zone, Amhara, Ethiopia</span>
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill"></i> 
                            <span><a href="tel:0928293370">0928293370</a></span>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i> 
                            <span><a href="mailto:tadege4340@gmail.com">tadege4340@gmail.com</a></span>
                        </li>
                    </ul>
                </div>

                <!-- Column 4: Need Help? -->
                <div class="col-lg-3 col-md-6">
                    <h3>NEED HELP?</h3>
                    <p class="footer-desc">
                        If you cannot log in or have issues with your student records, please contact the Registrar Office.
                    </p>
                    <a href="contactus.php" class="btn-support">Contact Support</a>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <div class="container text-center">
                <p>&copy; <?= date('Y') ?> EduSphere Academy • SIMS. All rights reserved.</p>
                <p>Designed with <i class="bi bi-heart-fill text-danger mx-1"></i> by Tadege Yilkal</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JAVASCRIPT TO SWITCH PAGES INSTANTLY -->
    <script>
        function showPage(pageId) {
            // 1. Hide all sections
            document.getElementById('section-home').style.display = 'none';
            document.getElementById('section-info').style.display = 'none';
            
            // 2. Show the selected section
            document.getElementById('section-' + pageId).style.display = 'block';

            // 3. Update active link styling in Navbar
            document.getElementById('link-home').classList.remove('active');
            document.getElementById('link-info').classList.remove('active');
            
            document.getElementById('link-' + pageId).classList.add('active');

            // Scroll to top when switching
            window.scrollTo(0, 0);
        }
    </script>
</body>
</html>