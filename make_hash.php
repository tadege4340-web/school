<?php
$password = 'tadege@2123';
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "<h3>Copy this exact hash:</h3>";
echo "<input type='text' value='" . $hash . "' style='width: 100%; padding: 10px; font-size: 16px;' readonly>";
?>