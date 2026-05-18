<?php
$password = 'admin123';
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Copy this hash:<br><br>";
echo $hash;
?>