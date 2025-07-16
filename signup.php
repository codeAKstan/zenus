<?php
// The order of includes matters. Get $db first.
$db = require_once 'config/database.php';
require_once 'includes/auth.php';

// Check if database connection is valid
if (!($db instanceof PDO)) {
    // Log the error for debugging (check your XAMPP PHP error logs)
    error_log("Failed to get database connection in signup.php");
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
    // Handle file upload
    $profilePicture = '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/profiles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExtension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $fileExtension;
        $uploadPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadPath)) {
            $profilePicture = $uploadPath;
        }
    }
    
    $userData = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name' => trim($_POST['last_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'phone_number' => trim($_POST['phone_number'] ?? ''),
        'country' => $_POST['country'] ?? '',
        'account_type' => $_POST['account_type'] ?? 'personal',
        'occupation' => trim($_POST['occupation'] ?? ''),
        'home_address' => trim($_POST['home_address'] ?? ''),
        'state' => trim($_POST['state'] ?? ''),
        'gender' => $_POST['gender'] ?? '',
        'date_of_birth' => $_POST['date_of_birth'] ?? '',
        'account_currency' => $_POST['account_currency'] ?? 'USD',
        'profile_picture' => $profilePicture
    ];
    
    // Validation
    $required = ['first_name', 'last_name', 'email', 'password'];
    $missing = [];
    foreach ($required as $field) {
        if (empty($userData[$field])) {
            $missing[] = $field;
        }
    }
    
    if (!empty($missing)) {
        $message = 'Please fill in all required fields: ' . implode(', ', $missing);
        $messageType = 'error';
    } elseif ($_POST['password'] !== $_POST['confirm_password']) {
        $message = 'Passwords do not match';
        $messageType = 'error';
    } elseif (!isset($_POST['agree_terms'])) {
        $message = 'You must agree to the terms and conditions';
        $messageType = 'error';
    } else {
        $result = $auth->register($userData);
        if ($result['success']) {
            // Show success message instead of immediate redirect
            $message = $result['message'] . ' Please check your email for welcome instructions.';
            $messageType = 'success';
            // Optional: Clear form data on success
            $_POST = [];
        } else {
            $message = $result['message'];
            $messageType = 'error';
        }
        
        if ($result['success']) {
            //header('Location: login.php?registered=1');
            //exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Zenus Bank</title>
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card signup-card">
            <div class="auth-header">
                <h1 class="logo">ZENUS<br>BANK</h1>
            </div>
            
            <div class="auth-content">
                <h2>Create Account</h2>
                <p class="auth-subtitle">Join Zenus Bank and start your global banking journey</p>
                
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" enctype="multipart/form-data" class="auth-form signup-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" placeholder="First Name" required value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Last Name" required value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="hello@example.com" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select id="country" name="country" required>
                                <option value="">Select Country</option>
                                <option value="US" <?php echo ($_POST['country'] ?? '') === 'US' ? 'selected' : ''; ?>>United States</option>
                                <option value="CA" <?php echo ($_POST['country'] ?? '') === 'CA' ? 'selected' : ''; ?>>Canada</option>
                                <option value="GB" <?php echo ($_POST['country'] ?? '') === 'GB' ? 'selected' : ''; ?>>United Kingdom</option>
                                <option value="AU" <?php echo ($_POST['country'] ?? '') === 'AU' ? 'selected' : ''; ?>>Australia</option>
                                <option value="DE" <?php echo ($_POST['country'] ?? '') === 'DE' ? 'selected' : ''; ?>>Germany</option>
                                <option value="FR" <?php echo ($_POST['country'] ?? '') === 'FR' ? 'selected' : ''; ?>>France</option>
                                <option value="JP" <?php echo ($_POST['country'] ?? '') === 'JP' ? 'selected' : ''; ?>>Japan</option>
                                <option value="SG" <?php echo ($_POST['country'] ?? '') === 'SG' ? 'selected' : ''; ?>>Singapore</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone_number">Your Phone Number</label>
                            <div class="phone-input">
                                <span class="phone-prefix">+</span>
                                <input type="tel" id="phone_number" name="phone_number" placeholder="1 440 941 4254" value="<?php echo htmlspecialchars($_POST['phone_number'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="account_type">Account Type</label>
                            <select id="account_type" name="account_type" required>
                                <option value="">Select Account Type</option>
                                <option value="personal" <?php echo ($_POST['account_type'] ?? '') === 'personal' ? 'selected' : ''; ?>>Personal</option>
                                <option value="business" <?php echo ($_POST['account_type'] ?? '') === 'business' ? 'selected' : ''; ?>>Business</option>
                                <option value="corporate" <?php echo ($_POST['account_type'] ?? '') === 'corporate' ? 'selected' : ''; ?>>Corporate</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="occupation">Occupation</label>
                            <input type="text" id="occupation" name="occupation" placeholder="Occupation" value="<?php echo htmlspecialchars($_POST['occupation'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="home_address">Home Address</label>
                            <input type="text" id="home_address" name="home_address" placeholder="Home Address" value="<?php echo htmlspecialchars($_POST['home_address'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" placeholder="State" value="<?php echo htmlspecialchars($_POST['state'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" <?php echo ($_POST['gender'] ?? '') === 'male' ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo ($_POST['gender'] ?? '') === 'female' ? 'selected' : ''; ?>>Female</option>
                                <option value="other" <?php echo ($_POST['gender'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
                                <option value="prefer_not_to_say" <?php echo ($_POST['gender'] ?? '') === 'prefer_not_to_say' ? 'selected' : ''; ?>>Prefer not to say</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($_POST['date_of_birth'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="account_currency">Account Currency</label>
                            <select id="account_currency" name="account_currency">
                                <option value="USD" <?php echo ($_POST['account_currency'] ?? 'USD') === 'USD' ? 'selected' : ''; ?>>USD - US Dollar</option>
                                <option value="EUR" <?php echo ($_POST['account_currency'] ?? '') === 'EUR' ? 'selected' : ''; ?>>EUR - Euro</option>
                                <option value="GBP" <?php echo ($_POST['account_currency'] ?? '') === 'GBP' ? 'selected' : ''; ?>>GBP - British Pound</option>
                                <option value="CAD" <?php echo ($_POST['account_currency'] ?? '') === 'CAD' ? 'selected' : ''; ?>>CAD - Canadian Dollar</option>
                                <option value="AUD" <?php echo ($_POST['account_currency'] ?? '') === 'AUD' ? 'selected' : ''; ?>>AUD - Australian Dollar</option>
                                <option value="JPY" <?php echo ($_POST['account_currency'] ?? '') === 'JPY' ? 'selected' : ''; ?>>JPY - Japanese Yen</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <div class="file-input">
                            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                            <div class="file-input-display">
                                <button type="button" class="file-browse-btn">Browse...</button>
                                <span class="file-selected">No file selected.</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-text">
                        <p>Managing your money through Internet Banking is quick and secure - and it only takes a few simple steps to register. You can do things like pay people, check your balance and manage bills, standing orders and Direct Debits.</p>
                        
                        <p>For the security of customers, any unauthorised attempt to access customer bank information will be monitored and may be subject to legal action.</p>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                        </div>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="agree_terms" required>
                            <span class="checkmark"></span>
                            I certify that I am 18 years of age or older, and agree to the <a href="#" target="_blank">User Agreement</a> and <a href="#" target="_blank">Privacy Policy</a>.
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create account</button>
                </form>
                
                <div class="auth-footer">
                    <p><a href="login.php">Sign in to your account</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // File input handling
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const fileSelected = document.querySelector('.file-selected');
            if (e.target.files.length > 0) {
                fileSelected.textContent = e.target.files[0].name;
            } else {
                fileSelected.textContent = 'No file selected.';
            }
        });
        
        document.querySelector('.file-browse-btn').addEventListener('click', function() {
            document.getElementById('profile_picture').click();
        });
    </script>
</body>
</html>
