<?php
// footer.php
?>
        </div> <!-- Close content-wrapper -->
    </div> <!-- Close main-content -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
        function toggleDropdown(menuId) {
            const menu = document.getElementById(menuId);
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        }
    </script>
</body>
</html>
