<?php
if (!isset($settings)) {
    require_once __DIR__ . '/../config/settings.php';
}
?>
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Banking</h4>
                <ul>
                    <li><a href="services.php#personal">Personal Banking</a></li>
                    <li><a href="services.php#business">Business Banking</a></li>
                    <li><a href="services.php#corporate">Corporate Banking</a></li>
                    <li><a href="services.php#investment">Investment Services</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Solutions</h4>
                <ul>
                    <li><a href="services.php#api">API Integration</a></li>
                    <li><a href="services.php#payments">Payment Processing</a></li>
                    <li><a href="services.php#cards">Card Issuance</a></li>
                    <li><a href="services.php#compliance">Compliance Tools</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Company</h4>
                <ul>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="#careers">Careers</a></li>
                    <li><a href="#press">Press</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Contact</h4>
                <ul>
                    <li><a href="mailto:<?php echo htmlspecialchars($settings['contact_email'] ?? 'info@zenusbank.com'); ?>">
                        <?php echo htmlspecialchars($settings['contact_email'] ?? 'info@zenusbank.com'); ?>
                    </a></li>
                    <li><a href="tel:<?php echo htmlspecialchars($settings['contact_phone'] ?? '+1-555-123-4567'); ?>">
                        <?php echo htmlspecialchars($settings['contact_phone'] ?? '+1 (555) 123-4567'); ?>
                    </a></li>
                    <li><?php echo htmlspecialchars($settings['contact_address'] ?? '123 Financial District, New York, NY 10004'); ?></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#privacy">Privacy Policy</a></li>
                    <li><a href="#terms">Terms of Service</a></li>
                    <li><a href="#compliance">Compliance</a></li>
                    <li><a href="#security">Security</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="footer-social">
                <a href="<?php echo htmlspecialchars($settings['facebook_url'] ?? '#'); ?>" class="social-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="<?php echo htmlspecialchars($settings['twitter_url'] ?? '#'); ?>" class="social-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </a>
                <a href="<?php echo htmlspecialchars($settings['linkedin_url'] ?? '#'); ?>" class="social-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
            </div>
            
            <div class="footer-copyright">
                <p>&copy; 2024 <?php echo htmlspecialchars($settings['company_name'] ?? 'Zenus Bank'); ?>. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
