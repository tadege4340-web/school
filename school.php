<?php
// school.php - Single Page Application (Home, News)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSphere - School Management</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- YOUR SEPARATE CSS FILE -->
    <link rel="stylesheet" href="school.css">
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
                    <!-- Home (Stays on page) -->
                    <li class="nav-item">
                        <a class="nav-link active" href="#" id="link-home" onclick="showPage('home')">Home</a>
                    </li>
                    <!-- News (Stays on page) -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="link-news" onclick="showPage('news')">News</a>
                    </li>
                    <!-- Contact Us (Goes to contactus.php file) -->
                    <li class="nav-item">
                        <a class="nav-link" href="contactus.php">Contact Us</a>
                    </li>
                    <!-- Login (Goes to loginf.php file) -->
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
                            <p class="text-muted">Tailored for Grades 9-12, focusing on Science, Arts, and Business streams.</p>
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

    <!-- ================= 2. NEWS SECTION ================= -->
    <div id="section-news" style="display: none;">
        <div class="container py-5 mt-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Latest School News</h2>
                <p class="text-muted">Stay updated with what's happening at EduSphere Academy.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="news-card">
                        <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Graduation">
                        <div class="p-4">
                            <span class="badge bg-primary mb-2">Events</span>
                            <h5 class="fw-bold">Grade 12 Graduation Ceremony</h5>
                            <p class="text-muted small mb-4">Join us in celebrating the Class of 2026 on June 15th at the main auditorium.</p>
                            <button class="btn-read-more">Read More <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="news-card">
                        <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Science Fair">
                        <div class="p-4">
                            <span class="badge bg-success mb-2">Academics</span>
                            <h5 class="fw-bold">Annual Science & Arts Fair</h5>
                            <p class="text-muted small mb-4">Grade 9 and 10 students showcased amazing projects in our recent science fair.</p>
                            <button class="btn-read-more">Read More <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="news-card">
                        <img src="https://images.unsplash.com/photo-1546410531-bb4caa6b424d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Sports">
                        <div class="p-4">
                            <span class="badge bg-warning text-dark mb-2">Sports</span>
                            <h5 class="fw-bold">Inter-School Football Championship</h5>
                            <p class="text-muted small mb-4">Our varsity team secured first place in the regional championship last weekend.</p>
                            <button class="btn-read-more">Read More <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
// login_instructions.php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login Guide • EduSphere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f4f6fb; font-family: 'Poppins', sans-serif; }
        .instruction-card { background: #fff; border-radius: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 3rem; }
        .header-icon { font-size: 3rem; color: #3a7bd5; margin-bottom: 1rem; }
        .table-custom th { background-color: #0b1e33; color: white; font-weight: 500; }
        .table-custom td { vertical-align: middle; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="instruction-card">
                
                <!-- Header -->
                <div class="text-center mb-5">
                    <i class="bi bi-mortarboard-fill header-icon"></i>
                    <h2 class="fw-bold text-primary mb-3">📢 Welcome to EduSphere Academy!</h2>
                    <p class="text-muted fs-5">Student Portal Guide (Grades 9 - 12)</p>
                </div>

                <!-- Information List -->
                <div class="alert alert-info rounded-4 mb-5" style="border-left: 5px solid #3a7bd5;">
                    <h5 class="fw-bold mb-3"><i class="bi bi-info-circle-fill me-2"></i>This system allows students to access:</h5>
                    <ul class="mb-0">
                        <li>All enrolled courses for their specific Grade and Stream (Natural/Social).</li>
                        <li>Academic Status — detailed exam results and grade reports.</li>
                        <li>Attendance and school-related announcements.</li>
                        <li>Other important academic information.</li>
                    </ul>
                </div>

                <!-- Login Guideline -->
                <h4 class="fw-bold text-dark mb-3">🔐 Login Guideline</h4>
                <p class="text-muted">
                    To view your academic details, you must first login. The login link is located on the main page. 
                    When the login screen is displayed, you must enter your <strong>Student ID</strong> and your <strong>Default Password</strong>.
                </p>
                <p class="text-muted mb-4">
                    Refer to the following example table on how to use your ID number as your username and your initial password.
                </p>

                <!-- Example Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-hover table-custom rounded-3">
                        <thead>
                            <tr>
                                <th class="ps-3">Student Full Name</th>
                                <th>Student ID (Username)</th>
                                <th>Temporary Password</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3 fw-bold">Tadege Yilkal Melaku</td>
                                <td><span class="badge bg-primary fs-6">STU-2026-001</span></td>
                                <td><code class="text-danger fw-bold">student123</code></td>
                                <td class="text-muted">All characters in the password are lowercase.</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-bold">Abebe Kebede Tesfaye</td>
                                <td><span class="badge bg-primary fs-6">STU-2026-002</span></td>
                                <td><code class="text-danger fw-bold">student123</code></td>
                                <td class="text-muted">Same default password for everyone.</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-bold">Sara Yohannes Mekonnen</td>
                                <td><span class="badge bg-primary fs-6">STU-2026-003</span></td>
                                <td><code class="text-danger fw-bold">student123</code></td>
                                <td class="text-muted">Change password after first login.</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-bold">Dawit Tadesse Alemu</td>
                                <td><span class="badge bg-primary fs-6">STU-2026-004</span></td>
                                <td><code class="text-danger fw-bold">student123</code></td>
                                <td class="text-muted">Contact admin if you face issues.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Action Button -->
                <div class="text-center mt-5">
                    <a href="loginf.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold" style="background-color: #0b1e33;">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Go to Login Page
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>

    
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JAVASCRIPT TO SWITCH PAGES INSTANTLY (Home, News) -->
    <script>
        function showPage(pageId) {
            // 1. Hide all sections
            document.getElementById('section-home').style.display = 'none';
            document.getElementById('section-news').style.display = 'none';
            
            // 2. Show the selected section
            document.getElementById('section-' + pageId).style.display = 'block';

            // 3. Update active link styling in Navbar
            document.getElementById('link-home').classList.remove('active');
            document.getElementById('link-news').classList.remove('active');
            
            document.getElementById('link-' + pageId).classList.add('active');
        }
    </script>
</body>
</html>
<?php
// footer.php
?>
        </div> <!-- Close content-wrapper -->
    </div> <!-- Close main-content -->

    <!-- Include the Universal Footer -->
    <?php include 'footerall.php'; ?>
