<?php include_once 'config/settings-configuration.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #121212;
            --card-dark: #1e1e1e;
            --text-primary: #e0e0e0;
            --text-secondary: #a0a0a0;
            --accent: #bb86fc;
            --input-bg: #2d2d2d;
        }
        
        body {
            background-color: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: system-ui, -apple-system, sans-serif;
        }
        
        .auth-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .auth-card {
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
        }
        
        .btn-primary:hover {
            background-color: #a370db;
            color: #000;
        }
        
        .forgot-password {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            display: block;
            text-align: center;
            margin-top: 1rem;
        }
        
        .forgot-password:hover {
            color: var(--accent);
        }
        
        .auth-header {
            margin-bottom: 2rem;
        }
        
        .auth-header h1 {
            font-size: 1.75rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
        
        .auth-header p {
            color: var(--text-secondary);
            font-size: 1rem;
        }
        
        @media (max-width: 767.98px) {
            .auth-container {
                padding: 1rem;
            }
            
            .col-md-6:first-child {
                margin-bottom: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container auth-container">
        <div class="auth-header text-center">
            <h1>Authentication</h1>
            <p>PWEASE! SIGN IN OR CREATE A NEW ONE PWEASE :3</p>
        </div>
        
        <div class="row g-4">
            
            <div class="col-md-6">
                <div class="card auth-card">
                    <div class="card-header">
                        <h2>Sign In</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="dashboard/admin/authentication/admin-class.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                            
                            <div class="mb-3">
                                <label for="signin-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="signin-email" name="email" placeholder="Enter your email" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="signin-password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="signin-password" name="password" placeholder="Enter your password" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100" name="btn-signin">
                                Sign In
                            </button>
                            
                            <a href="forget-pass.php" class="forgot-password">
                                Forgot password?
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            
         
            <div class="col-md-6">
                <div class="card auth-card">
                    <div class="card-header">
                        <h2>Register</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="dashboard/admin/authentication/admin-class.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                            
                            <div class="mb-3">
                                <label for="signup-username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="signup-username" name="username" placeholder="Choose a username" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="signup-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="signup-email" name="email" placeholder="Enter your email" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="signup-password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="signup-password" name="password" placeholder="Create a password" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100" name="btn-signup">
                                Register
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>