<?php
require_once 'includes/auth.php';
require_once 'config/database.php';

$auth = new Auth($db);

// Check if user is logged in
if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$user = $auth->getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Zenus Bank</title>
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
        <div style="text-align: center; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <h1 style="color: #2d1b69; margin-bottom: 20px;">Welcome to Zenus Bank</h1>
            <p style="color: #666; margin-bottom: 30px;">Hello, <?php echo htmlspecialchars($user['name']); ?>!</p>
            <p style="color: #666; margin-bottom: 30px;">Your dashboard is under construction.</p>
            <a href="logout.php" style="background: #00d4aa; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: 600;">Logout</a>
        </div>
    </div>
</body>
</html>
