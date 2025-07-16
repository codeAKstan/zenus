<?php
require_once 'includes/auth.php';
require_once 'config/database.php';

$auth = new Auth($db);
$auth->logout();

header('Location: login.php?logged_out=1');
exit();
?>
