<?php require_once 'config/settings.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($settings['company_name'] ?? 'Zenus Bank'); ?> - <?php echo htmlspecialchars($settings['company_tagline'] ?? 'Global Banking and Fintech Solutions'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($settings['company_description'] ?? 'The first truly global neobank and fintech platform designed for the modern world.'); ?>">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text">
                        <h1><?php echo htmlspecialchars($settings['hero_title'] ?? 'Banking beyond borders'); ?></h1>
                        <p><?php echo htmlspecialchars($settings['hero_subtitle'] ?? 'The first truly global neobank and fintech platform designed for the modern world. Experience seamless cross-border banking and the convenience of US banking.'); ?></p>
                        <button class="btn btn-primary">Get Started</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bank & Fintech Platform Section -->
        <section class="platform-section">
            <div class="container">
                <div class="platform-content">
                    <div class="platform-text">
                        <h2>Bank & Fintech platform</h2>
                        <p>Our state-of-the-art technology, extensive partnerships, and innovative processes are available via our modern platform to help you build, launch, and scale your financial products for your customers.</p>
                        <button class="btn btn-outline">EXPLORE MORE</button>
                    </div>
                    <div class="platform-image">
                        <div class="database-illustration">
                            <img src="assets/images/corebanking_3d.webp" alt="Core Banking 3D Platform Architecture" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Partners Section -->
        <section class="partners-section">
            <div class="container">
                <p class="partners-text">Integrated with best-in-class partners to meet your banking operations</p>
                <div class="partners-logos">
                    <img src="assets/images/visa.webp" alt="Visa" class="partner-logo">
                    <img src="assets/images/dock_white.webp" alt="Dock" class="partner-logo">
                    <img src="assets/images/i2c_white.webp" alt="i2c" class="partner-logo">
                    <img src="assets/images/csu_white.webp" alt="csu white" class="partner-logo">
                    <img src="assets/images/pismo_white.webp" alt="pismo" class="partner-logo">
                </div>
            </div>
        </section>

        <!-- Services Sections -->
        <section class="services-section">
            <div class="container">
                <!-- Global Banking Solutions -->
                <div class="service-item">
                    <div class="service-content">
                        <div class="service-text">
                            <span class="service-category">FINANCIAL INSTITUTIONS</span>
                            <h3>Global banking solutions</h3>
                            <p>Unlock the power of fast, seamless and secure payments for your clients with our cutting-edge technology and comprehensive suite of banking solutions.</p>
                            <button class="btn btn-outline">EXPLORE MORE</button>
                        </div>
                        <div class="service-image">
                            <img src="assets/images/bank.webp" alt="Global banking solutions">
                        </div>
                    </div>
                </div>

                <!-- Global Treasury -->
                <div class="service-item reverse">
                    <div class="service-content">
                        <div class="service-text">
                            <span class="service-category">CORPORATE ENTITIES</span>
                            <h3>Global treasury</h3>
                            <p>Simplify and consolidate your business banking operations with our comprehensive treasury solutions. Gain total payment insights, real-time banking transactions designed to help you run your business more efficiently and cost-effectively.</p>
                            <button class="btn btn-outline">EXPLORE MORE</button>
                        </div>
                        <div class="service-image">
                            <img src="assets/images/man.webp" alt="Global treasury">
                        </div>
                    </div>
                </div>

                <!-- US Bank Account -->
                <div class="service-item">
                    <div class="service-content">
                        <div class="service-text">
                            <span class="service-category">INDIVIDUALS</span>
                            <h3>Open a US bank account in minutes</h3>
                            <p>A first-of-its-kind bank account without the need to be a US citizen or resident. Get your own personal US bank account and debit card to shop, pay bills, and send money worldwide.</p>
                            <button class="btn btn-outline">EXPLORE MORE</button>
                        </div>
                        <div class="service-image">
                            <img src="assets/images/family.webp" alt="US bank account">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Developer Portal -->
        <section class="developer-section">
            <div class="container">
                <div class="developer-content">
                    <div class="developer-text">
                        <span class="service-category">API INTEGRATION</span>
                        <h3>Developer Portal</h3>
                        <p>Integrate banking functionalities into your platform with our developer-friendly APIs. Our comprehensive documentation, SDKs, and sandbox environment make it easy to get started. Build innovative financial products, connect with our secure payment infrastructure, and leverage our global banking network to create seamless user experiences.</p>
                        <button class="btn btn-outline">EXPLORE MORE</button>
                    </div>
                    <div class="developer-image">
                        <div class="code-editor">
                            <div class="code-header">
                                <div class="code-dots">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                            <div class="code-content">
                                <pre><code>curl -X POST https://api.zenus.com/v1/accounts \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "account_type": "checking",
    "currency": "USD",
    "customer_id": "cust_123"
  }'</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Additional Services -->
        <section class="additional-services">
            <div class="container">
                <!-- Seamless Payments -->
                <div class="service-item">
                    <div class="service-content">
                        <div class="service-text">
                            <span class="service-category">PAYMENT RAILS</span>
                            <h3>Seamless payments</h3>
                            <p>Expand your reach around the globe with access to fast and seamless payments in multiple currencies. Our fast-growing network of payment rails enables you to send and receive money worldwide with competitive exchange rates.</p>
                            <button class="btn btn-outline">EXPLORE MORE</button>
                        </div>
                    </div>
                </div>

                <!-- BIN Sponsorship -->
                <div class="service-item">
                    <div class="service-content">
                        <div class="service-text">
                            <span class="service-category">GLOBAL CARD ISSUANCE</span>
                            <h3>BIN Sponsorship</h3>
                            <p>Our robust BIN sponsorship program enables you to issue payment cards with our BIN through a single partnership. Benefit from our comprehensive suite of card services and global reach.</p>
                            <button class="btn btn-outline">EXPLORE MORE</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2><?php echo htmlspecialchars($settings['cta_title'] ?? 'Let\'s start building'); ?></h2>
                    <p><?php echo htmlspecialchars($settings['cta_subtitle'] ?? 'Empower your institution with Zenus Bank\'s modern integration. Manage US accounts and ready for clients worldwide.'); ?></p>
                    <button class="btn btn-primary">GET STARTED</button>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
</body>
</html>
