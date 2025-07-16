<?php 
require_once 'config/settings.php';

// Get page content from database
$query = "SELECT * FROM pages WHERE page_slug = 'services' AND is_active = 1 LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute();
$page = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['page_title'] ?? 'Our Services'); ?> - <?php echo htmlspecialchars($settings['company_name'] ?? 'Zenus Bank'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page['meta_description'] ?? 'Explore our comprehensive banking services'); ?>">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <!-- Services Page Header -->
        <section class="services-header">
            <div class="container">
                <div class="services-header-content">
                    <h1>Powering new<br>financial<br>experiences</h1>
                    <p>Zenus fintech platform is actively being leveraged across the world by a wide range of financial institutions, from traditional banks to fintech players and other fintechs to improve and expand their services to millions of users.</p>
                </div>
            </div>
        </section>

        <!-- Optimize Revenue Section -->
        <section class="optimize-revenue">
            <div class="container">
                <div class="service-content">
                    <div class="service-text">
                        <span class="service-category">GLOBAL CARD ISSUANCE</span>
                        <h2>Optimize revenue</h2>
                        <p>Are you a bank, fintech, or issuing processor looking to expand revenue, retain clients, and enhance customer experiences? Our comprehensive suite of streamlined integration ensures fast, cost-effective access to Visa's global network for secure, compliant card programs.</p>
                        <button class="btn btn-outline">EXPLORE MORE</button>
                    </div>
                    <div class="service-image">
                        <img src="assets/images/hand-card.webp?height=300&width=400" alt="Hand holding purple card">
                    </div>
                </div>
            </div>
        </section>

        <!-- Build Banking Solution Section -->
        <section class="build-banking">
            <div class="container">
                <div class="service-content reverse">
                    <div class="service-text">
                        <span class="service-category">EMBEDDED BANKING</span>
                        <h2>Build your banking solution</h2>
                        <p>Unlock the power of Zenus' banking infrastructure through APIs and leverage our expertise, technology, and licenses to create your own embedded banking solutions. Whether you're looking to enhance your product portfolio or launch a digital banking platform, Zenus' embedded banking solutions enable you to do so without the complexity and cost of building compared to starting from scratch.</p>
                        <button class="btn btn-outline">EXPLORE MORE</button>
                    </div>
                    <div class="service-image">
                        <img src="assets/images/laptop-phone.webp?height=300&width=400" alt="Laptop and phone showing Zenus Bank interface">
                    </div>
                </div>
            </div>
        </section>

        <!-- Award Winning Technology Section -->
        <section class="award-technology">
            <div class="container">
                <h2>Award winning technology</h2>
                <div class="awards-logos">
                    <img src="assets/images/bta-uk.webp?height=60&width=120" alt="Award 1" class="award-logo">
                    <img src="assets/images/bta-us.webp?height=60&width=120" alt="Award 2" class="award-logo">
                    <img src="assets/images/finovate.webp?height=60&width=120" alt="Award 5" class="award-logo">
                    <img src="assets/images/paytech-uk.webp?height=60&width=120" alt="Award 3" class="award-logo">
                    <img src="assets/images/paytech-us.webp?height=60&width=120" alt="Award 4" class="award-logo">
                </div>
                <button class="btn btn-outline">ZENUS RECOGNITIONS</button>
            </div>
        </section>

        <!-- Boost Payment Efficiency Section -->
        <section class="boost-payment">
            <div class="container">
                <div class="payment-content">
                    <div class="payment-text">
                        <span class="service-category">PAYMENT SOLUTIONS</span>
                        <h2>Boost payment efficiency</h2>
                        <p>Elevate your business with our advanced payment solutions, enabling real-time transactions and seamless cross-border payments for your customers. Additionally, Zenus Payment Facilitator (PayFac) simplifies payment processing, enhances sales, and streamlines customer experience with secure and efficient transactions.</p>
                        <button class="btn btn-outline">EXPLORE MORE</button>
                    </div>
                    <div class="payment-diagram">
                        <div class="payment-flow">
                            <div class="flow-item">USD</div>
                            <div class="flow-item">EUR</div>
                            <div class="flow-item">GBP</div>
                            <div class="flow-item">JPY</div>
                            <div class="flow-item">CAD</div>
                            <div class="flow-item">AUD</div>
                            <div class="flow-item">CHF</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Drive Business Growth Section -->
        <section class="drive-growth">
            <div class="container">
                <div class="service-content">
                    <div class="service-text">
                        <span class="service-category">DIGITAL TRANSFORMATION</span>
                        <h2>Drive business growth</h2>
                        <p>Empower your business potential with Zenus Bank's Digital Transformation services. By integrating our advanced technology solutions into your existing operations, enhance customer experiences, and stay ahead in the competitive financial landscape. Our comprehensive suite of digital tools and platforms, enabling you to innovate and operate more efficiently.</p>
                        <button class="btn btn-outline">EXPLORE MORE</button>
                    </div>
                    <div class="service-image">
                        <img src="assets/images/payment-solution-2-min.webp?height=300&width=400" alt="Person working on laptop">
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA Section -->
        <section class="services-cta">
            <div class="container">
                <div class="cta-content">
                    <h2>Ready to take your business to the next level?</h2>
                    <button class="btn btn-primary">CONTACT US</button>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
</body>
</html>
