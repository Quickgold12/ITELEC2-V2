<?php
include_once 'config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        
        input[type="password"] {
            width: 100%;
            background-color: var(--input-bg);
            border: 2px solid var(--accent);
            color: var(--text-primary);
            padding: 0.75rem;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        
        input[type="password"]:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(187, 134, 252, 0.25);
        }
        
        input[type="password"]::placeholder {
            color: var(--text-secondary);
            opacity: 0.7;
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
        <div class="form-section" id="reset-password-section">
            <h1>RESET PASSWORD</h1>
            <form action="dashboard/admin/authentication/admin-class.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">

                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" placeholder="Enter new password" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                </div>

                <button type="submit" name="btn-reset-password">RESET PASSWORD</button>
            </form>

            <a href="index.php" class="forgot-password-link">Back to Sign In</a>
        </div>
    </div>

</body>
</html>