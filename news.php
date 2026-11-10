<?php
// news.php - News Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSphere - News</title>
    
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
            <a class="navbar-brand" href="school.php">
                <i class="bi bi-mortarboard-fill me-2"></i>EduSphere
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="school.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="news.php">News</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light rounded-pill px-4" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- News Section -->
    <div class="container py-5 mt-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Latest School News</h2>
            <p class="text-muted">Stay updated with what's happening at EduSphere Academy.</p>
        </div>
        
        <div class="row g-4">
            <!-- News Item 1 -->
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
            
            <!-- News Item 2 -->
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
            
            <!-- News Item 3 -->
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