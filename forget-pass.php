<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
   
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
            margin-bottom: 1rem;
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
    </style>
</head>
<body>
    <div class="container reset-container">
        <div class="reset-header">
            <h1>Reset Password</h1>
            <p>Enter your email and new password</p>
        </div>
        
        <div class="card reset-card">
            <div class="card-header">
                <h2>New Password</h2>
            </div>
            <div class="card-body p-4">
                <form action="dashboard/admin/authentication/admin-class.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                    
                    <div class="mb-3">
                        <label for="reset-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="reset-email" name="email" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="reset-password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="reset-password" name="password" placeholder="Enter your new password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" name="btn-signin">
                        Reset Password
                    </button>
                    
                    <a href="index.php" class="back-link">
                        Back to login
                    </a>
                </form>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>