<?php
session_start();
$db = require_once '../config/database.php'; // Capture the returned connection

// Simple admin authentication (in production, use proper admin authentication)
if (!isset($_SESSION['admin_logged_in'])) {
    if ($_POST && ($_POST['admin_password'] ?? '') === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
    } else {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Admin Login</title>
            <style>
                body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; background: #f5f5f5; }
                .login-form { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
                button { background: #007cba; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; }
            </style>
        </head>
        <body>
            <form method="POST" class="login-form">
                <h2>Admin Login</h2>
                <input type="password" name="admin_password" placeholder="Admin Password" required>
                <button type="submit">Login</button>
            </form>
        </body>
        </html>
        <?php
        exit();
    }
}

// Handle template updates
if ($_POST && isset($_POST['update_template'])) {
    $templateId = $_POST['template_id'];
    $subject = $_POST['subject'];
    $bodyHtml = $_POST['body_html'];
    $bodyText = $_POST['body_text'];
    
    $query = "UPDATE email_templates SET subject = ?, body_html = ?, body_text = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $subject);
    $stmt->bindParam(2, $bodyHtml);
    $stmt->bindParam(3, $bodyText);
    $stmt->bindParam(4, $templateId);
    
    if ($stmt->execute()) {
        $message = "Template updated successfully!";
    } else {
        $message = "Error updating template.";
    }
}

// Get all templates
$query = "SELECT * FROM email_templates ORDER BY template_name";
$stmt = $db->prepare($query);
$stmt->execute();
$templates = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get selected template for editing
$selectedTemplate = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $query = "SELECT * FROM email_templates WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $editId);
    $stmt->execute();
    $selectedTemplate = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Templates - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .templates-list { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .template-item { padding: 15px; border: 1px solid #eee; margin-bottom: 10px; border-radius: 4px; display: flex; justify-content: space-between; align-items: center; }
        .edit-form { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        .form-group textarea { height: 300px; font-family: monospace; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #007cba; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .variables-info { background: #f8f9fa; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .logout { float: right; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Email Templates Management</h1>
            <a href="?logout=1" class="btn btn-secondary logout">Logout</a>
            <?php if (isset($_GET['logout'])) { session_destroy(); header('Location: email-templates.php'); exit(); } ?>
        </div>
        
        <?php if (isset($message)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <div class="templates-list">
            <h2>Email Templates</h2>
            <?php foreach ($templates as $template): ?>
                <div class="template-item">
                    <div>
                        <strong><?php echo htmlspecialchars($template['template_name']); ?></strong><br>
                        <small><?php echo htmlspecialchars($template['subject']); ?></small>
                    </div>
                    <a href="?edit=<?php echo $template['id']; ?>" class="btn btn-primary">Edit</a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($selectedTemplate): ?>
            <div class="edit-form">
                <h2>Edit Template: <?php echo htmlspecialchars($selectedTemplate['template_name']); ?></h2>
                
                <div class="variables-info">
                    <strong>Available Variables:</strong>
                    <?php 
                    $variables = json_decode($selectedTemplate['variables'], true);
                    if ($variables) {
                        echo implode(', ', array_map(function($var) { return '{{' . $var . '}}'; }, $variables));
                    }
                    ?>
                </div>
                
                <form method="POST">
                    <input type="hidden" name="template_id" value="<?php echo $selectedTemplate['id']; ?>">
                    
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" id="subject" name="subject" value="<?php echo htmlspecialchars($selectedTemplate['subject']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="body_html">HTML Body:</label>
                        <textarea id="body_html" name="body_html" required><?php echo htmlspecialchars($selectedTemplate['body_html']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="body_text">Text Body:</label>
                        <textarea id="body_text" name="body_text"><?php echo htmlspecialchars($selectedTemplate['body_text']); ?></textarea>
                    </div>
                    
                    <button type="submit" name="update_template" class="btn btn-success">Update Template</button>
                    <a href="email-templates.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
