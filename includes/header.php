<?php
if (!isset($settings)) {
    require_once __DIR__ . '/../config/settings.php';
}
?>
<header class="header">
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <a href="index.php" class="logo">
                    <span class="logo-text">
                        <img src="<?php echo htmlspecialchars($settings['logo_path'] ?? 'assets/images/zenus-logo.png'); ?>" 
                             alt="<?php echo htmlspecialchars($settings['company_name'] ?? 'Zenus Bank'); ?> logo" 
                             style="height: 60px; width: auto;">
                    </span>
                </a>
            </div>
            
            <div class="nav-menu" id="navMenu">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="about.php" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="services.php" class="nav-link">Services</a>
                    </li>
                    <li class="nav-item">
                        <a href="contact.php" class="nav-link">Contact</a>
                    </li>
                </ul>
            </div>
            
            <div class="nav-actions">
                <button class="btn btn-success">
                    <a href="signup.php" class="nav-link">SIGN UP</a></button>
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>
</header>
