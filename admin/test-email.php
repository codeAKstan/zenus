<?php
session_start();
$db = require_once '../config/database.php'; // Capture the returned connection
require_once '../includes/email_service.php';

// Simple admin authentication
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: email-templates.php');
    exit();
}

$emailService = new EmailService($db);
$message = '';

if ($_POST && isset($_POST['send_test'])) {
    $templateName = $_POST['template_name'];
    $testEmail = $_POST['test_email'];
    
    // Sample variables for testing
    $variables = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => $testEmail,
        'account_type' => 'Personal',
        'account_currency' => 'USD',
        'registration_date' => date('F j, Y'),
        'login_url' => 'https://' . $_SERVER['HTTP_HOST'] . '/login.php'
    ];
    
    $result = $emailService->sendEmail($templateName, $testEmail, $variables);
    $message = $result['message'];
}

// Get all templates
$query = "SELECT template_name, subject FROM email_templates WHERE is_active = 1";
$stmt = $db->prepare($query);
$stmt->execute();
$templates = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; }
        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #007cba; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Test Email Sending</h1>
            
            <?php if ($message): ?>
                <div class="alert <?php echo strpos($message, 'success') !== false ? 'alert-success' : 'alert-error'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="template_name">Email Template:</label>
                    <select id="template_name" name="template_name" required>
                        <option value="">Select Template</option>
                        <?php foreach ($templates as $template): ?>
                            <option value="<?php echo htmlspecialchars($template['template_name']); ?>">
                                <?php echo htmlspecialchars($template['template_name']); ?> - <?php echo htmlspecialchars($template['subject']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="test_email">Test Email Address:</label>
                    <input type="email" id="test_email" name="test_email" required placeholder="test@example.com">
                </div>
                
                <button type="submit" name="send_test" class="btn btn-primary">Send Test Email</button>
                <a href="email-templates.php" class="btn btn-secondary">Back to Templates</a>
            </form>
            
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                <h3>Test Variables Used:</h3>
                <ul>
                    <li><strong>first_name:</strong> John</li>
                    <li><strong>last_name:</strong> Doe</li>
                    <li><strong>email:</strong> [Your test email]</li>
                    <li><strong>account_type:</strong> Personal</li>
                    <li><strong>account_currency:</strong> USD</li>
                    <li><strong>registration_date:</strong> <?php echo date('F j, Y'); ?></li>
                    <li><strong>login_url:</strong> <?php echo 'https://' . $_SERVER['HTTP_HOST'] . '/login.php'; ?></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
