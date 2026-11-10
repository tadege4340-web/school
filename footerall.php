<?php
// footerall.php
?>
    <!-- ================= SITE FOOTER ================= -->
    <footer class="site-footer">
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
                        <li><a href="news.php">News & Events</a></li>
                        <li><a href="loginf.php">Student Login</a></li>
                        <li><a href="#">Academic Calendar</a></li>
                        <li><a href="#">FAQs</a></li>
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
                            <span><a href="tel:0928293370">0928293370</a> / <a href="tel:0918169491">0918169491</a></span>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i> 
                            <span><a href="mailto:tadege4340@gmail.com">tadege4340@gmail.com</a></span>
                        </li>
                        <li>
                            <i class="bi bi-envelope-open-fill"></i> 
                            <span><a href="mailto:tadegeyilkal@gmail.com">tadegeyilkal@gmail.com</a></span>
                        </li>
                        <li>
                            <i class="bi bi-telegram"></i> 
                            <span><a href="https://t.me/tadege2123" target="_blank">@tadege2123</a></span>
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

    <!-- Sidebar & Dropdown Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) sidebar.classList.toggle('show');
        }
        function toggleDropdown(menuId) {
            const menu = document.getElementById(menuId);
            if (menu) {
                menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
            }
        }
    </script>
</body>
</html>