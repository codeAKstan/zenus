<?php 
require_once 'config/settings.php';

// Get page content from database
$query = "SELECT * FROM pages WHERE page_slug = 'about' AND is_active = 1 LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute();
$page = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['page_title'] ?? 'About Us'); ?> - <?php echo htmlspecialchars($settings['company_name'] ?? 'Zenus Bank'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page['meta_description'] ?? 'Learn about our mission and values'); ?>">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <!-- About Page Header -->
        <section class="about-header">
            <div class="container">
                <div class="about-header-content">
                    <h1>Banking<br>beyond<br>borders</h1>
                </div>
            </div>
        </section>

        <!-- Who We Are Section -->
        <section class="who-we-are">
            <div class="container">
                <div class="who-content">
                    <div class="who-text">
                        <h2>Who we are</h2>
                        <p>Zenus is a global digital bank that is building the next generation of cross-border embedded finance. Founded in 2019 with a mandate to enable banking beyond borders, today the organization enjoys a global presence and is recognized in the industry as a forefront innovator. Zenus Bank operates at the intersection between traditional finance and cutting-edge technological innovation.</p>
                        
                        <p>As a fully licensed bank, it offers the security, stability, and convenience of a fully regulated financial institution. Meanwhile, as a technology pioneer, Zenus is spearheading the world's transition towards Embedded Finance. By enabling other organizations to leverage its patented processes, Zenus Bank is helping to introduce a new era of new, exceptional financial services.</p>
                    </div>
                    <div class="who-video">
                        <div class="video-container">
                            <video controls poster="assets/images/?height=300&width=400">
                                <source src="assets/images/Zenus_Bank_Video.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Where We're Heading Section -->
        <section class="where-heading">
            <div class="container">
                <div class="heading-content">
                    <div class="heading-image">
                        <img src="assets/images/boat.webp?height=400&width=400" alt="Zenus Bank sailing towards the future">
                    </div>
                    <div class="heading-text">
                        <h2>Where we're heading</h2>
                        
                        <div class="vision-mission">
                            <div class="vision">
                                <h3>OUR VISION</h3>
                                <p>To create a world where physical borders don't limit the financial services you have access to.</p>
                            </div>
                            
                            <div class="mission">
                                <h3>OUR MISSION</h3>
                                <p>To build a financial institution that gives people and businesses across the world access to the security, freedom and convenience of US banking.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Leadership Section -->
        <section class="our-leadership">
            <div class="container">
                <div class="leadership-content">
                    <div class="leadership-text">
                        <h2>Our leadership</h2>
                        <p>We have the perfect blend of banking, technology experience and entrepreneurial drive at the helm.</p>
                        <button class="btn btn-outline">MEET THE LEADERSHIP TEAM</button>
                    </div>
                    <div class="leadership-grid">
                        <!-- <div class="leader-photo">
                            <img src="assets/images/boat.webp?height=150&width=150" alt="Leadership Team Member">
                        </div> -->
                        <div class="leader-photo">
                            <img src="assets/images/grupo.webp?height=400&width=400" alt="Leadership Team Member">
                        </div>
                        <!-- <div class="leader-photo">
                            <img src="assets/images/?height=150&width=150" alt="Leadership Team Member">
                        </div>
                        <div class="leader-photo">
                            <img src="assets/images/?height=150&width=150" alt="Leadership Team Member">
                        </div>
                        <div class="leader-photo">
                            <img src="assets/images/?height=150&width=150" alt="Leadership Team Member">
                        </div>
                        <div class="leader-photo">
                            <img src="assets/images/?height=150&width=150" alt="Leadership Team Member">
                        </div> -->
                    </div>
                </div>
            </div>
        </section>

        <!-- Working at Zenus Section -->
        <section class="working-at-zenus">
            <div class="container">
                <div class="working-content">
                    <div class="working-image">
                        <img src="assets/images/zenus-bank-students-happy.webp?height=400&width=400" alt="Working at Zenus Bank">
                    </div>
                    <div class="working-text">
                        <h2>Working at Zenus</h2>
                        <p>At Zenus Bank, we foster a culture of collaboration and innovation. With a diverse team of professionals, we are dedicated to reshaping banking experiences through creativity and excellence.</p>
                        
                        <p>If you're ready to be part of the revolution in cross-border banking and payments, explore the exciting career opportunities at Zenus Bank.</p>
                        
                        <button class="btn btn-outline">JOIN OUR TEAM</button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
</body>
</html>
