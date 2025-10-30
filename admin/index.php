<?php
session_start();

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

// Handle login
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Dummy credentials
    if ($email === 'admin@example.com' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid email or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Elpis Initiative Uganda</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--color-background);
            padding: 20px;
        }
        
        .login-card {
            background: var(--color-card);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 32px 48px;
            width: 100%;
            max-width: 800px;
            box-shadow: var(--shadow-md);
        }
        
        .login-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--color-border);
        }
        
        .login-logo img {
            height: 50px;
            width: auto;
        }
        
        .login-header-text {
            flex: 1;
        }
        
        .login-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--color-foreground);
            margin: 0 0 4px 0;
        }
        
        .login-subtitle {
            font-size: 13px;
            color: var(--color-muted-foreground);
            margin: 0;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--color-foreground);
            margin-bottom: 6px;
        }
        
        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid #e0e0e0;
            border-radius: var(--radius-md);
            font-size: 13px;
            transition: all 0.2s ease;
            background: #ffffff;
            color: #1a1a1a;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .form-input::placeholder {
            color: #999;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--color-accent-pink);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1), 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .form-input:hover {
            border-color: #c0c0c0;
        }
        
        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 14px;
            margin-bottom: 24px;
            border-left: 4px solid #c33;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .login-btn {
            width: 100%;
            padding: 12px 36px;
            background: #EC4899;
            color: white;
            border: none;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(236, 72, 153, 0.3);
            margin-top: 24px;
        }
        
        .login-btn svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.5;
        }
        
        .login-btn:hover {
            background: #d63384;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.4);
        }
        
        .login-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(236, 72, 153, 0.3);
        }
        
        .login-footer {
            font-size: 12px;
            color: var(--color-muted-foreground);
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--color-border);
        }
        
        @media (max-width: 768px) {
            .login-card {
                padding: 32px 24px;
            }
            
            .login-header {
                flex-direction: column;
                text-align: center;
                gap: 16px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <img src="../EUI Black Logo.png" alt="Elpis Initiative Uganda">
                </div>
                <div class="login-header-text">
                    <h1 class="login-title">Admin Login</h1>
                    <p class="login-subtitle">Enter your credentials to access the dashboard</p>
                </div>
            </div>
            
            <?php if ($error): ?>
                <div class="error-message">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="admin@example.com"
                            required
                            autocomplete="email"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                        >
                    </div>
                </div>
                
                <button type="submit" class="login-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    Sign In
                </button>
            </form>
            
            <div class="login-footer">
                &copy; <?php echo date('Y'); ?> Elpis Initiative Uganda. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
