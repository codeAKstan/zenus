<?php
// The order of includes matters. Get $db first.
$db = require_once 'config/database.php';
require_once 'includes/auth.php';

// Check if database connection is valid
if (!($db instanceof PDO)) {
    // Log the error for debugging (check your XAMPP PHP error logs)
    error_log("Failed to get database connection in login.php");
    // Display a user-friendly error message and stop execution
    die("Database connection failed. Please try again later or contact support.");
}

$auth = new Auth($db);
$message = '';
$messageType = '';

// Redirect if already logged in
if ($auth->isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

if ($_POST) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if ($email && $password) {
        $result = $auth->login($email, $password);
        if ($result['success']) {
            header('Location: dashboard.php');
            exit();
        } else {
            $message = $result['message'];
            $messageType = 'error';
        }
    } else {
        $message = 'Please fill in all fields';
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Zenus Bank</title>
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="logo">ZENUS<br>BANK</h1>
            </div>
            
            <div class="auth-content">
                <h2>Sign in</h2>
                <p class="auth-subtitle">Sign in with your email address</p>
                
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" class="auth-form">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Email Address" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <div class="form-group-header">
                            <label for="password">Password</label>
                            <a href="forgot-password.php" class="forgot-link">Forgot your password?</a>
                        </div>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
                
                <div class="auth-footer">
                    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
