<?php
include_once 'config/settings-configuration.php';
require_once 'dashboard/admin/authentication/admin-class.php';

// Check if we have the reset email in session
if (!isset($_SESSION['reset_email'])) {
    header("Location: forget-pass.php");
    exit;
}

$email = $_SESSION['reset_email'];
$message = '';
$message_type = '';

// Handle OTP verification
if (isset($_POST['btn-verify-reset'])) {
    $otp = trim($_POST['otp']);
    $csrf_token = trim($_POST['csrf_token']);
    
    // Verify OTP
    $admin = new ADMIN();
    
    // Call verifyResetOtp with empty values for username and password
    // These will be set in the next step
    $admin->verifyResetOtp('', $email, '', '', $otp, $csrf_token);
    
    // If verification fails, the verifyResetOtp method will redirect
    // If we get here, verification succeeded
    $message = "OTP verified successfully. Please set your new password.";
    $message_type = "success";
    
    // Set a flag to show the password form
    $_SESSION['otp_verified'] = true;
}

// Handle password reset
if (isset($_POST['btn-reset'])) {
    $csrf_token = trim($_POST['csrf_token']);
    $new_password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validate CSRF token
    if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        $message = "Invalid CSRF Token";
        $message_type = "error";
    } 
    // Validate passwords match
    elseif ($new_password !== $confirm_password) {
        $message = "Passwords do not match";
        $message_type = "error";
    } 
    // Validate password strength
    elseif (strlen($new_password) < 8 || !preg_match('/[A-Z]/', $new_password) || 
            !preg_match('/[a-z]/', $new_password) || !preg_match('/\d/', $new_password) || 
            !preg_match('/[^a-zA-Z\d]/', $new_password)) {
        $message = "Password does not meet requirements";
        $message_type = "error";
    } else {
        // Update password
        $admin = new ADMIN();
        $conn = $admin->conn;
        
        // Hash the password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update the password in the database
        $stmt = $conn->prepare("UPDATE user SET password = :password WHERE email = :email");
        $result = $stmt->execute(array(
            ":password" => $hashed_password,
            ":email" => $email
        ));
        
        if ($result) {
            // Log the activity
            $stmt = $conn->prepare("SELECT id FROM user WHERE email = :email");
            $stmt->execute(array(":email" => $email));
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                $admin->logs("Password Reset Successfully", $user['id']);
            }
            
            $message = "Password has been reset successfully! You can now login with your new password.";
            $message_type = "success";
            
            // Clear session variables
            unset($_SESSION['reset_email']);
            unset($_SESSION['otp_verified']);
            unset($_SESSION['ResetOTP']);
            
            // Generate new CSRF token
            unset($_SESSION['csrf_token']);
            $csrf_token = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $csrf_token;
            
            // Set a flag to redirect after a delay
            $redirect_to_login = true;
        } else {
            $message = "Error updating password. Please try again.";
            $message_type = "error";
        }
    }
}

// Determine which form to show
$show_password_form = isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        
        .reset-container {
            max-width: 450px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .reset-card {
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
        
        .btn-primary:disabled {
            background-color: var(--text-secondary);
            opacity: 0.6;
            cursor: not-allowed;
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
        
        .reset-header {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .reset-header h1 {
            font-size: 1.75rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
        
        .reset-header p {
            color: var(--text-secondary);
            font-size: 1rem;
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
        
        .password-requirements {
            background-color: rgba(187, 134, 252, 0.1);
            border-left: 3px solid var(--accent);
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0 4px 4px 0;
        }
        
        .password-requirements h6 {
            color: var(--accent);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        
        .password-requirements ul {
            margin: 0;
            padding-left: 1rem;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }
        
        .password-requirements li {
            margin-bottom: 0.25rem;
        }
        
        .password-strength {
            height: 4px;
            background-color: var(--input-bg);
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            transition: width 0.3s ease, background-color 0.3s ease;
            border-radius: 2px;
        }
        
        .form-text {
            color: var(--text-secondary);
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }
        
        .password-match {
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }
        
        .match-success {
            color: var(--success);
        }
        
        .match-error {
            color: var(--error);
        }
    </style>
</head>
<body>
    <div class="container reset-container">
        <div class="reset-header">
            <h1>Reset Password</h1>
            <p><?php echo $show_password_form ? 'Create a new secure password for your account' : 'Verify your identity to reset your password'; ?></p>
        </div>
        
        <div class="card reset-card">
            <div class="card-header">
                <h2><?php echo $show_password_form ? 'New Password' : 'Verify OTP'; ?></h2>
            </div>
            <div class="card-body p-4">
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'error'; ?>">
                        <?php echo $message; ?>
                    </div>
                    
                    <?php if (isset($redirect_to_login)): ?>
                    <script>
                        setTimeout(function() {
                            window.location.href = 'index.php';
                        }, 3000); // Redirect after 3 seconds
                    </script>
                    <div class="text-center mt-3">
                        <p>Redirecting to login page in 3 seconds...</p>
                        <a href="index.php" class="btn btn-primary mt-2">
                            Go to Login Now
                        </a>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php if ($show_password_form && !isset($redirect_to_login)): ?>
                    <div class="password-requirements">
                        <h6>Password Requirements:</h6>
                        <ul>
                            <li>At least 8 characters long</li>
                            <li>Contains uppercase and lowercase letters</li>
                            <li>Contains at least one number</li>
                            <li>Contains at least one special character</li>
                        </ul>
                    </div>
                    
                    <form action="" method="POST" id="resetForm">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your new password" required>
                            <div class="password-strength">
                                <div class="password-strength-bar" id="strengthBar"></div>
                            </div>
                            <div class="form-text" id="strengthText">Password strength will appear here</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your new password" required>
                            <div class="password-match" id="matchText"></div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" name="btn-reset" id="resetBtn" disabled>
                            Reset Password
                        </button>
                        
                        <a href="index.php" class="back-link">
                            Back to login
                        </a>
                    </form>
                <?php elseif (!isset($redirect_to_login)): ?>
                    <div class="text-center">
                        <p>Please verify your OTP first. Check your email for the verification code.</p>
                        <a href="verify-otp.php" class="btn btn-primary mt-3">
                            Go to OTP Verification
                        </a>
                        
                        <a href="index.php" class="back-link">
                            Back to login
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if ($show_password_form && !isset($redirect_to_login)): ?>
    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        const matchText = document.getElementById('matchText');
        const resetBtn = document.getElementById('resetBtn');
        
        // Password strength checker
        function checkPasswordStrength(password) {
            let score = 0;
            let feedback = [];
            
            if (password.length >= 8) score++;
            else feedback.push('At least 8 characters');
            
            if (/[a-z]/.test(password)) score++;
            else feedback.push('Lowercase letter');
            
            if (/[A-Z]/.test(password)) score++;
            else feedback.push('Uppercase letter');
            
            if (/\d/.test(password)) score++;
            else feedback.push('Number');
            
            if (/[^a-zA-Z\d]/.test(password)) score++;
            else feedback.push('Special character');
            
            return { score, feedback };
        }
        
        // Update password strength indicator
        function updatePasswordStrength() {
            const password = passwordInput.value;
            const { score, feedback } = checkPasswordStrength(password);
            
            const percentage = (score / 5) * 100;
            strengthBar.style.width = percentage + '%';
            
            if (score === 0) {
                strengthBar.style.backgroundColor = 'transparent';
                strengthText.textContent = 'Password strength will appear here';
                strengthText.style.color = 'var(--text-secondary)';
            } else if (score <= 2) {
                strengthBar.style.backgroundColor = 'var(--error)';
                strengthText.textContent = 'Weak - Missing: ' + feedback.join(', ');
                strengthText.style.color = 'var(--error)';
            } else if (score <= 3) {
                strengthBar.style.backgroundColor = '#ffa726';
                strengthText.textContent = 'Fair - Missing: ' + feedback.join(', ');
                strengthText.style.color = '#ffa726';
            } else if (score <= 4) {
                strengthBar.style.backgroundColor = '#66bb6a';
                strengthText.textContent = 'Good - Missing: ' + feedback.join(', ');
                strengthText.style.color = '#66bb6a';
            } else {
                strengthBar.style.backgroundColor = 'var(--success)';
                strengthText.textContent = 'Strong password';
                strengthText.style.color = 'var(--success)';
            }
            
            checkFormValidity();
        }
        
        // Check password match
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (confirmPassword === '') {
                matchText.textContent = '';
                matchText.className = 'password-match';
            } else if (password === confirmPassword) {
                matchText.textContent = 'Passwords match';
                matchText.className = 'password-match match-success';
            } else {
                matchText.textContent = 'Passwords do not match';
                matchText.className = 'password-match match-error';
            }
            
            checkFormValidity();
        }
        
        // Check if form is valid
        function checkFormValidity() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            const { score } = checkPasswordStrength(password);
            
            const isValid = score === 5 && password === confirmPassword && password !== '';
            resetBtn.disabled = !isValid;
        }
        
        // Event listeners
        passwordInput.addEventListener('input', updatePasswordStrength);
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
        
        // Form submission
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            const { score } = checkPasswordStrength(password);
            
            if (score < 5) {
                e.preventDefault();
                alert('Password does not meet all requirements');
                return;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match');
                return;
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>