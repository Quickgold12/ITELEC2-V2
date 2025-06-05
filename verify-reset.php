<?php
    include_once 'config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verify OTP</title>
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
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, sans-serif;
            padding: 1rem;
        }
        
        .container {
            width: 100%;
            max-width: 450px;
        }
        
        .form-section {
            background-color: var(--card-dark);
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        
        h1 {
            font-size: 1.75rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            text-align: center;
            letter-spacing: 0.5px;
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
        
        form {
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-label {
            display: block;
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        input[type="text"] {
            width: 100%;
            background-color: var(--input-bg);
            border: 2px solid var(--accent);
            color: var(--text-primary);
            padding: 0.75rem;
            border-radius: 4px;
            font-size: 1.2rem;
            text-align: center;
            letter-spacing: 4px;
            font-weight: 500;
            transition: border-color 0.3s ease;
        }
        
        input[type="text"]:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(187, 134, 252, 0.25);
        }
        
        input[type="text"]::placeholder {
            color: var(--text-secondary);
            opacity: 0.7;
            letter-spacing: normal;
            font-size: 1rem;
        }
        
        .form-hint {
            display: block;
            color: var(--text-secondary);
            font-size: 0.75rem;
            margin-top: 0.5rem;
            text-align: center;
        }
        
        button {
            width: 100%;
            background-color: var(--accent);
            border: none;
            padding: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            border-radius: 4px;
            color: #000;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        button:hover {
            background-color: #a370db;
        }
        
        .forgot-password-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            display: block;
            text-align: center;
            margin-top: 1rem;
            transition: color 0.3s ease;
        }
        
        .forgot-password-link:hover {
            color: var(--accent);
        }
        
        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                padding: 0.5rem;
            }
            
            .form-section {
                padding: 1.5rem;
            }
            
            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-section" id="otp-verification-section">
            <h1>ENTER OTP</h1>
            
            <div class="info-box">
                <p>Please enter the 6-digit verification code that was sent to your email to complete the verification process.</p>
            </div>
            
            <form action="dashboard/admin/authentication/admin-class.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>" />

                <div class="form-group">
                    <label class="form-label">Verification Code</label>
                    <input type="text" name="otp" placeholder="Enter your OTP" maxlength="6" required pattern="\d{6}" title="6 digit OTP" autocomplete="off" />
                    <span class="form-hint">Enter the 6-digit code from your email</span>
                </div>

                <button type="submit" name="btn-verify-otp">VERIFY OTP</button>
            </form>

            <a href="forgot-password.php" class="forgot-password-link">Resend OTP / Back to Forgot Password</a>
        </div>
    </div>

</body>
</html>