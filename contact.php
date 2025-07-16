<?php 
require_once 'config/settings.php';

// Get page content from database
$query = "SELECT * FROM pages WHERE page_slug = 'contact' AND is_active = 1 LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute();
$page = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
$message = '';
if ($_POST) {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $messageText = htmlspecialchars($_POST['message'] ?? '');
    
    if ($name && $email && $subject && $messageText) {
        // Here you would typically save to database or send email
        $message = '<div class="alert alert-success">Thank you for your message. We\'ll get back to you soon!</div>';
    } else {
        $message = '<div class="alert alert-error">Please fill in all fields.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['page_title'] ?? 'Contact Us'); ?> - <?php echo htmlspecialchars($settings['company_name'] ?? 'Zenus Bank'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page['meta_description'] ?? 'Get in touch with our team'); ?>">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <!-- Page Header -->
        <section class="page-header">
            <div class="container">
                <h1><?php echo htmlspecialchars($page['page_title'] ?? 'Contact Us'); ?></h1>
                <p>Get in touch with our team for support, partnerships, or general inquiries.</p>
            </div>
        </section>

        <!-- Contact Content -->
        <section class="page-content">
            <div class="container">
                <div class="contact-wrapper">
                    <div class="contact-info">
                        <div class="content-wrapper">
                            <?php echo $page['page_content'] ?? '<p>Content not found.</p>'; ?>
                        </div>
                        
                        <div class="contact-details">
                            <div class="contact-item">
                                <h3>Email</h3>
                                <p><a href="mailto:<?php echo htmlspecialchars($settings['contact_email'] ?? 'info@zenusbank.com'); ?>">
                                    <?php echo htmlspecialchars($settings['contact_email'] ?? 'info@zenusbank.com'); ?>
                                </a></p>
                            </div>
                            
                            <div class="contact-item">
                                <h3>Phone</h3>
                                <p><a href="tel:<?php echo htmlspecialchars($settings['contact_phone'] ?? '+1-555-123-4567'); ?>">
                                    <?php echo htmlspecialchars($settings['contact_phone'] ?? '+1 (555) 123-4567'); ?>
                                </a></p>
                            </div>
                            
                            <div class="contact-item">
                                <h3>Address</h3>
                                <p><?php echo htmlspecialchars($settings['contact_address'] ?? '123 Financial District, New York, NY 10004'); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-form">
                        <h2>Send us a message</h2>
                        <?php echo $message; ?>
                        
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" id="subject" name="subject" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" rows="5" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
</body>
</html>
