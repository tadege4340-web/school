<?php
require 'db.php';

echo "<h2>Cleaning up student 3232...</h2>";

try {
    // 1. Delete ALL courses for 3232
    $pdo->exec("DELETE FROM student_courses WHERE student_id = '3232'");
    
    // 2. Insert exactly 4 courses
    $pdo->exec("INSERT INTO student_courses (student_id, course_code, grade, stream) VALUES 
    ('3232', 'MATH-9', '9', 'General'),
    ('3232', 'ENG-9', '9', 'General'),
    ('3232', 'PHY-9-286', '9', 'General'),
    ('3232', 'HIS-9-914', '9', 'General')");

    // 3. Delete ALL marks for 3232
    $pdo->exec("DELETE FROM marks WHERE student_id = '3232'");

    // 4. Insert exactly 2 marks
    $pdo->exec("INSERT INTO marks (student_id, subject, marks_obtained, total_marks, exam_date, status) VALUES 
    ('3232', 'Mathematics', 91.00, 100.00, '2026-11-09', 'Approved'),
    ('3232', 'history', 99.00, 100.00, '2026-11-09', 'Approved')");

    echo "<h3>✅ Cleanup complete!</h3>";
    echo "<p>Student 3232 now has exactly 4 courses and 2 marks.</p>";

} catch (PDOException $e) {
    echo "<h3 style='color:red;'>❌ Error: " . $e->getMessage() . "</h3>";
}
?>