<?php
// school.php - Single Page Application (Home, News)
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
    
    <style>
        /* Custom styles for the new grade overview section */
        .grade-card {
            background: #fff;
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            border: 1px solid #f1f5f9;
        }
        .grade-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        .grade-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .grade-9 { color: #3a7bd5; }
        .grade-10 { color: #198754; }
        .grade-11 { color: #fd7e14; }
        .grade-12 { color: #d946ef; }
        
        .stream-badge {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            margin: 0.2rem;
        }
        
        /* SIMS Definition Box */
        .sims-definition {
            background: #fff;
            border-left: 5px solid #3a7bd5;
            border-radius: 1rem;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 4rem;
        }

        /* Image styling */
        .sims-image {
            width: 100%;
            max-width: 400px;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 1rem;
        }
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
                        <a class="nav-link" href="#" id="link-news" onclick="showPage('news')">News</a>
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
        
        <!-- Hero Banner -->
        <header class="hero">
            <div class="container">
                <h1>Welcome to EduSphere Academy</h1>
                <p>Empowering students from Grade 9 to Grade 12 with the knowledge and skills to shape the future.</p>
                <a href="#sims-info" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary">Learn About SIMS</a>
            </div>
        </header>

        <!-- SIMS Definition Box with Image -->
        <section id="sims-info" class="container py-5">
            <div class="sims-definition">
                <div class="row align-items-center">
                    <!-- Left Column: Image -->
                    <div class="col-lg-5 mb-4 mb-lg-0 text-center">
                        <!-- Make sure your image is named image.png and is in the same folder -->
                        <img src="image.png" alt="SIMS Diagram" class="sims-image shadow-sm">
                    </div>
                    
                    <!-- Right Column: Text -->
                    <div class="col-lg-7 ps-lg-5">
                        <h3 class="fw-bold text-primary mb-3">
                            <i class="bi bi-info-circle-fill me-2"></i>Student Information Management System (SIMS)
                        </h3>
                        <p class="text-muted fs-6" style="line-height: 1.8;">
                            The Student Information Management System (SIMS) is a software application designed to manage and streamline student data and administrative processes in our Secondary School (Grades 9–12). It ensures the accurate storage, retrieval, and management of student information, including personal details, academic records, course enrollment, and exam results.
                        </p>
                        <p class="text-muted fs-6 mb-0" style="line-height: 1.8;">
                            Traditionally, student information is maintained manually, which is prone to errors, data loss, and inefficiency. Our proposed system automates these tasks to save time, improve accuracy, and support decision-making. It is an Integrated Software that automates the following student-related business processes:
                        </p>
                        <div class="row mt-4">
                            <div class="col-6 col-md-3 text-center mb-3">
                                <i class="bi bi-book fs-2 text-primary"></i>
                                <h6 class="fw-bold mt-2">Courses</h6>
                            </div>
                            <div class="col-6 col-md-3 text-center mb-3">
                                <i class="bi bi-people fs-2 text-success"></i>
                                <h6 class="fw-bold mt-2">Teachers</h6>
                            </div>
                            <div class="col-6 col-md-3 text-center mb-3">
                                <i class="bi bi-person-badge fs-2 text-warning"></i>
                                <h6 class="fw-bold mt-2">Students</h6>
                            </div>
                            <div class="col-6 col-md-3 text-center mb-3">
                                <i class="bi bi-bar-chart fs-2 text-info"></i>
                                <h6 class="fw-bold mt-2">Grades</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grade 9-12 Academic Overview -->
            <div class="text-center mb-5">
                <h2 class="fw-bold">Secondary School Programs</h2>
                <p class="text-muted fs-5">Tailored education for Grades 9 through 12 with specialized streams.</p>
            </div>
            
            <div class="row g-4">
                <!-- Grade 9 -->
                <div class="col-md-6 col-lg-3">
                    <div class="grade-card text-center">
                        <i class="bi bi-1-circle-fill grade-icon grade-9"></i>
                        <h4 class="fw-bold">Grade 9</h4>
                        <p class="text-muted small">Foundation year focusing on core subjects and general knowledge.</p>
                        <span class="badge bg-primary-subtle text-primary stream-badge">General Stream</span>
                    </div>
                </div>

                <!-- Grade 10 -->
                <div class="col-md-6 col-lg-3">
                    <div class="grade-card text-center">
                        <i class="bi bi-2-circle-fill grade-icon grade-10"></i>
                        <h4 class="fw-bold">Grade 10</h4>
                        <p class="text-muted small">Completing core requirements and preparing for stream selection.</p>
                        <span class="badge bg-success-subtle text-success stream-badge">General Stream</span>
                    </div>
                </div>

                <!-- Grade 11 -->
                <div class="col-md-6 col-lg-3">
                    <div class="grade-card text-center">
                        <i class="bi bi-3-circle-fill grade-icon grade-11"></i>
                        <h4 class="fw-bold">Grade 11</h4>
                        <p class="text-muted small">Specialized learning in Natural or Social Sciences.</p>
                        <div class="d-flex justify-content-center flex-wrap">
                            <span class="badge bg-warning-subtle text-warning stream-badge">Natural Science</span>
                            <span class="badge bg-info-subtle text-info stream-badge">Social Science</span>
                        </div>
                    </div>
                </div>

                <!-- Grade 12 -->
                <div class="col-md-6 col-lg-3">
                    <div class="grade-card text-center">
                        <i class="bi bi-4-circle-fill grade-icon grade-12"></i>
                        <h4 class="fw-bold">Grade 12</h4>
                        <p class="text-muted small">Final year prep for national exams and university entry.</p>
                        <div class="d-flex justify-content-center flex-wrap">
                            <span class="badge bg-danger-subtle text-danger stream-badge">Natural Science</span>
                            <span class="badge bg-secondary-subtle text-secondary stream-badge">Social Science</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section id="features" class="py-5 bg-light">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Why Choose Us?</h2>
                    <p class="text-muted">We provide the best environment for learning and growth.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card text-center p-4 h-100 bg-white rounded-4 shadow-sm">
                            <i class="bi bi-book-half feature-icon text-primary fs-1 mb-3"></i>
                            <h4>Modern Curriculum</h4>
                            <p class="text-muted">Tailored for Grades 9-12, focusing on Science, Arts, and Business streams.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card text-center p-4 h-100 bg-white rounded-4 shadow-sm">
                            <i class="bi bi-people-fill feature-icon text-success fs-1 mb-3"></i>
                            <h4>Expert Teachers</h4>
                            <p class="text-muted">Our faculty consists of highly qualified and dedicated educators.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card text-center p-4 h-100 bg-white rounded-4 shadow-sm">
                            <i class="bi bi-laptop feature-icon text-warning fs-1 mb-3"></i>
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

    <!-- ================= PROFESSIONAL FOOTER ================= -->
    <footer class="site-footer">
        <div class="container footer-container">
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h3>EDUSPHERE ACADEMY</h3>
                    <p class="footer-desc">
                        Student Information Management System (SIMS) — A secure, centralized platform for managing academic records, courses, and student data efficiently.
                    </p>
                    <div class="footer-social">
                        <a href="https://facebook.com/tadegeyilkal" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://t.me/tadege2123" target="_blank" aria-label="Telegram"><i class="bi bi-telegram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="mailto:tadege4340@gmail.com" aria-label="Email"><i class="bi bi-envelope-fill"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h3>QUICK LINKS</h3>
                    <ul class="footer-links">
                        <li><a href="school.php">Home</a></li>
                        <li><a href="contactus.php">Contact Us</a></li>
                        <li><a href="#" onclick="showPage('news')">News & Events</a></li>
                        <li><a href="loginf.php">Student Login</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h3>CONTACT US</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="bi bi-geo-alt-fill"></i> 
                            <span>Injibara, Awi Zone, Amhara, Ethiopia</span>
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill"></i> 
                            <span><a href="tel:0928293370">0928293370</a> / <a href="tel:0918169491">0918169491</a></span>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i> 
                            <span><a href="mailto:tadege4340@gmail.com">tadege4340@gmail.com</a></span>
                        </li>
                        <li>
                            <i class="bi bi-facebook"></i> 
                            <span><a href="https://facebook.com/tadegeyilkal" target="_blank">Tadege Yilkal</a></span>
                        </li>
                        <li>
                            <i class="bi bi-telegram"></i> 
                            <span><a href="https://t.me/tadege2123" target="_blank">@tadege2123</a></span>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h3>NEED HELP?</h3>
                    <p class="footer-desc">If you cannot log in or have issues with your records, please contact the Registrar Office.</p>
                    <a href="contactus.php" class="btn-support">Contact Support</a>
                </div>
            </div>
        </div>

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
            document.getElementById('section-home').style.display = 'none';
            document.getElementById('section-news').style.display = 'none';
            document.getElementById('section-' + pageId).style.display = 'block';

            document.getElementById('link-home').classList.remove('active');
            document.getElementById('link-news').classList.remove('active');
            document.getElementById('link-' + pageId).classList.add('active');

            window.scrollTo(0, 0);
        }
    </script>
</body>
</html>