<?php
// Logout functionality
// In a real application, this would clear session data

// For now, just redirect to a logout confirmation or login page
// You can implement proper session destruction here

// Example session destruction (uncomment when sessions are implemented):
// session_start();
// session_unset();
// session_destroy();

// Redirect to login page or show logout message
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out - Elpis Initiative Uganda Admin</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .logout-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: var(--spacing-6);
        }
        
        .logout-card {
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        
        .logout-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto var(--spacing-4);
            color: var(--color-accent-pink);
        }
        
        .logout-title {
            font-size: var(--font-2xl);
            font-weight: 700;
            margin-bottom: var(--spacing-2);
        }
        
        .logout-message {
            color: var(--color-muted-foreground);
            margin-bottom: var(--spacing-6);
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <div class="logout-card card glass-card">
            <div class="card-content">
                <svg class="logout-icon" xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                
                <h1 class="logout-title">Successfully Logged Out</h1>
                <p class="logout-message">You have been logged out of the Elpis Initiative Uganda Admin Dashboard.</p>
                
                <a href="dashboard.php" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>

