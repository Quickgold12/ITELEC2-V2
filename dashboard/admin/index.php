<?php
require_once 'authentication/admin-class.php';

$admin = new ADMIN();
if(!$admin->isUserLoggedIn()){
    $admin->redirect('../../');
}

$stmt = $admin->runQuery("SELECT * FROM user WHERE id = :id");
$stmt->execute(array(":id" => $_SESSION['adminSession']));
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            font-family: system-ui, -apple-system, sans-serif;
            padding: 2rem;
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            background-color: var(--card-dark);
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .welcome-section h1 {
            font-size: 1.75rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }
        
        .user-info {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }
        
        .user-email {
            color: var(--accent);
            font-weight: 500;
        }
        
        .signout-btn {
            background-color: var(--accent);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            border-radius: 4px;
            color: #000;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .signout-btn:hover {
            background-color: #a370db;
        }
        
        .signout-btn a {
            color: #000;
            text-decoration: none;
        }
        
        .dashboard-content {
            background-color: var(--card-dark);
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .dashboard-card {
            background-color: var(--input-bg);
            border-radius: 4px;
            padding: 1.5rem;
            border-left: 3px solid var(--accent);
        }
        
        .dashboard-card h3 {
            color: var(--text-primary);
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .dashboard-card p {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.4;
        }
        
        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: var(--success);
            border-radius: 50%;
            margin-right: 0.5rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .header {
                flex-direction: column;
                text-align: center;
            }
            
            .welcome-section h1 {
                font-size: 1.5rem;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .header,
            .dashboard-content {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <div class="welcome-section">
                <h1>Admin Dashboard</h1>
                <div class="user-info">
                    <span class="status-indicator"></span>
                    Welcome back, <span class="user-email"><?php echo $user_data['email'] ?></span>
                </div>
            </div>
            <button class="signout-btn">
                <a href="authentication/admin-class.php?admin_signout">Sign Out</a>
            </button>
        </div>
        
        <div class="dashboard-content">
            <h2 style="color: var(--text-primary); margin-bottom: 1rem; font-weight: 500;">Dashboard Overview</h2>
            
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>System Status</h3>
                    <p>All systems are running normally. Last updated: <?php echo date('M d, Y H:i'); ?></p>
                </div>
                
                <div class="dashboard-card">
                    <h3>User Account</h3>
                    <p>Account Type: Administrator<br>
                    Last Login: <?php echo date('M d, Y H:i'); ?></p>
                </div>
                
                <div class="dashboard-card">
                    <h3>Quick Actions</h3>
                    <p>Access your most frequently used administrative tools and settings from here.</p>
                </div>
                
                <div class="dashboard-card">
                    <h3>Security</h3>
                    <p>Your account is secure. Two-factor authentication is recommended for enhanced security.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>