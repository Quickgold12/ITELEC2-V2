<?php
include_once 'config/settings-configuration.php';

$message = '';
$message_type = '';

if (isset($_POST['btn-forgot'])) {
    $csrf_token = trim($_POST['csrf_token']);
    $email = trim($_POST['email']);
    
    // Validate CSRF token
    if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        $message = "Invalid CSRF Token";
        $message_type = "error";
    } else {
        // Store email in session for the reset flow
        $_SESSION['reset_email'] = $email;
        
        // Generate OTP
        $otp = rand(100000, 999999);
        
        // Call the sendResetOtp method from ADMIN class
        require_once 'dashboard/admin/authentication/admin-class.php';
        $admin = new ADMIN();
        $admin->sendResetOtp($otp, $email);
        
        // Note: sendResetOtp already redirects to verify-otp.php
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #121212;
            --card-dark: #1e1e1e;
            --text-primary: #e0e0e0;
            --text-secondary: #a0a0a0;
            --accent: #bb86fc;
            --input-bg: #2d2d2d;
            --success: #03dac6;
            --error: #cf6679;
        }
        
        body {
            background-color: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: system-ui, -apple-system, sans-serif;
        }
        
        .forgot-container {
            max-width: 450px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .forgot-card {
            background-color: var(--card-dark);
            border: none;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
        }
        
        .card-header h2 {
            font-size: 1.25rem;
            margin: 0;
            font-weight: 500;
            color: var(--text-primary);
        }
        
        .form-control {
            background-color: var(--input-bg);
            border: 2px solid var(--accent);
            color: var(--text-primary);
            padding: 0.75rem;
            border-radius: 4px;
        }
        
        .form-control:focus {
            background-color: var(--input-bg);
            color: var(--text-primary);
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(187, 134, 252, 0.25);
        }
        
        .form-control::placeholder {
            color: var(--text-secondary);
            opacity: 0.7;
        }
        
        .form-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .btn-primary {
            background-color: var(--accent);
            border: none;
            padding: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            border-radius: 4px;
            color: #000;
            width: 100%;
        }
        
        .btn-primary:hover {
            background-color: #a370db;
            color: #000;
        }
        
        .back-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            display: block;
            text-align: center;
            margin-top: 1rem;
        }
        
        .back-link:hover {
            color: var(--accent);
        }
        
        .forgot-header {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .forgot-header h1 {
            font-size: 1.75rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
        
        .forgot-header p {
            color: var(--text-secondary);
            font-size: 1rem;
        }
        
        .info-box {
            background-color: rgba(187, 134, 252, 0.1);
            border-left: 3px solid var(--accent);
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0 4px 4px 0;
        }
        
        .info-box p {
            margin: 0;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        
        .form-text {
            color: var(--text-secondary);
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }
        
        .alert {
            background-color: transparent;
            border-left: 3px solid;
            border-radius: 0;
            padding: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
        
        .alert-success {
            border-color: var(--success);
            color: var(--success);
        }
        
        .alert-error {
            border-color: var(--error);
            color: var(--error);
        }
    </style>
</head>
<body>
    <div class="container forgot-container">
        <div class="forgot-header">
            <h1>Forgot Password</h1>
            <p>Enter your email to receive a verification code</p>
        </div>
        
        <div class="card forgot-card">
            <div class="card-header">
                <h2>Password Recovery</h2>
            </div>
            <div class="card-body p-4">
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'error'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                
                <div class="info-box">
                    <p>We'll send a verification code to your email. You'll need this code to reset your password.</p>
                </div>
                
                <form action="dashboard/admin/authentication/admin-class.php" method="POST" id="forgotForm">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                    
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your registered email" required>
                        <div class="form-text">Enter the email address associated with your account</div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" name="btn-forgot-password">
                        Send Verification Code
                    </button>
                    
                    <a href="index.php" class="back-link">
                        Back to login
                    </a>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Form validation
        document.getElementById('forgotForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            
            if (!email) {
                e.preventDefault();
                alert('Please enter your email address');
                return;
            }
            
            // Basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address');
                return;
            }
        });
    </script>
</body>
</html>