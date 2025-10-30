<?php
/**
 * Database Connection Test
 * 
 * This file tests the database connection and verifies setup
 */

require_once __DIR__ . '/config/database.php';

// Enable error display for testing
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test - Elpis Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 3rem;
            max-width: 800px;
            width: 100%;
        }
        
        h1 {
            color: #1a1a1a;
            margin-bottom: 1rem;
            font-size: 2rem;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 2rem;
        }
        
        .test-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .test-section h2 {
            color: #1a1a1a;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        
        .status {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .status.success {
            background: #d4edda;
            color: #155724;
        }
        
        .status.error {
            background: #f8d7da;
            color: #721c24;
        }
        
        .status.warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .icon {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }
        
        .info-grid {
            display: grid;
            gap: 0.75rem;
            margin-top: 1rem;
        }
        
        .info-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 1rem;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        
        .info-value {
            color: #212529;
            font-family: 'Courier New', monospace;
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.3s;
            margin-top: 1rem;
        }
        
        .btn:hover {
            background: #5568d3;
        }
        
        .table-list {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .table-list li {
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔌 Database Connection Test</h1>
        <p class="subtitle">Elpis Initiative Uganda Admin Panel</p>
        
        <!-- Connection Test -->
        <div class="test-section">
            <h2>1. Database Connection</h2>
            <?php
            try {
                $conn = Database::getConnection();
                echo '<div class="status success"><span class="icon">✓</span> Connection Successful</div>';
                
                echo '<div class="info-grid">';
                echo '<div class="info-row"><span class="info-label">Host:</span><span class="info-value">' . DB_HOST . '</span></div>';
                echo '<div class="info-row"><span class="info-label">Database:</span><span class="info-value">' . DB_NAME . '</span></div>';
                echo '<div class="info-row"><span class="info-label">User:</span><span class="info-value">' . DB_USER . '</span></div>';
                echo '<div class="info-row"><span class="info-label">Charset:</span><span class="info-value">' . DB_CHARSET . '</span></div>';
                echo '</div>';
                
            } catch (Exception $e) {
                echo '<div class="status error"><span class="icon">✗</span> Connection Failed</div>';
                echo '<p style="color: #721c24; margin-top: 1rem;">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            ?>
        </div>
        
        <!-- Tables Test -->
        <div class="test-section">
            <h2>2. Database Tables</h2>
            <?php
            try {
                $tables = Database::query("SHOW TABLES");
                $tableCount = count($tables);
                $expectedTables = ['admin_users', 'applications', 'donations', 'subscriptions', 'activity_logs', 'newsletter_campaigns', 'email_queue', 'file_uploads'];
                
                if ($tableCount >= 8) {
                    echo '<div class="status success"><span class="icon">✓</span> Found ' . $tableCount . ' tables</div>';
                } else {
                    echo '<div class="status warning"><span class="icon">⚠</span> Found ' . $tableCount . ' tables (Expected: 8)</div>';
                }
                
                echo '<ul class="table-list">';
                foreach ($tables as $table) {
                    $tableName = array_values($table)[0];
                    echo '<li>' . $tableName . '</li>';
                }
                echo '</ul>';
                
            } catch (Exception $e) {
                echo '<div class="status error"><span class="icon">✗</span> Could not retrieve tables</div>';
                echo '<p style="color: #721c24; margin-top: 1rem;">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            ?>
        </div>
        
        <!-- Sample Data Test -->
        <div class="test-section">
            <h2>3. Sample Data</h2>
            <?php
            try {
                $appCount = Database::query("SELECT COUNT(*) as count FROM applications")[0]['count'];
                $donCount = Database::query("SELECT COUNT(*) as count FROM donations")[0]['count'];
                $subCount = Database::query("SELECT COUNT(*) as count FROM subscriptions")[0]['count'];
                $adminCount = Database::query("SELECT COUNT(*) as count FROM admin_users")[0]['count'];
                
                echo '<div class="info-grid">';
                echo '<div class="info-row"><span class="info-label">Applications:</span><span class="info-value">' . $appCount . ' records</span></div>';
                echo '<div class="info-row"><span class="info-label">Donations:</span><span class="info-value">' . $donCount . ' records</span></div>';
                echo '<div class="info-row"><span class="info-label">Subscriptions:</span><span class="info-value">' . $subCount . ' records</span></div>';
                echo '<div class="info-row"><span class="info-label">Admin Users:</span><span class="info-value">' . $adminCount . ' users</span></div>';
                echo '</div>';
                
                if ($appCount > 0 && $donCount > 0 && $subCount > 0 && $adminCount > 0) {
                    echo '<div class="status success" style="margin-top: 1rem;"><span class="icon">✓</span> Sample data loaded</div>';
                } else {
                    echo '<div class="status warning" style="margin-top: 1rem;"><span class="icon">⚠</span> Some tables are empty</div>';
                }
                
            } catch (Exception $e) {
                echo '<div class="status error"><span class="icon">✗</span> Could not retrieve data</div>';
                echo '<p style="color: #721c24; margin-top: 1rem;">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            ?>
        </div>
        
        <!-- Admin User Test -->
        <div class="test-section">
            <h2>4. Default Admin Account</h2>
            <?php
            try {
                $admin = Database::query("SELECT email, full_name, role, is_active FROM admin_users WHERE email = 'admin@example.com'");
                
                if (!empty($admin)) {
                    echo '<div class="status success"><span class="icon">✓</span> Default admin account exists</div>';
                    echo '<div class="info-grid">';
                    echo '<div class="info-row"><span class="info-label">Email:</span><span class="info-value">' . $admin[0]['email'] . '</span></div>';
                    echo '<div class="info-row"><span class="info-label">Name:</span><span class="info-value">' . $admin[0]['full_name'] . '</span></div>';
                    echo '<div class="info-row"><span class="info-label">Role:</span><span class="info-value">' . $admin[0]['role'] . '</span></div>';
                    echo '<div class="info-row"><span class="info-label">Status:</span><span class="info-value">' . ($admin[0]['is_active'] ? 'Active' : 'Inactive') . '</span></div>';
                    echo '</div>';
                    echo '<p style="margin-top: 1rem; padding: 1rem; background: #e7f3ff; border-radius: 4px; color: #004085;">';
                    echo '<strong>Login Credentials:</strong><br>';
                    echo 'Email: admin@example.com<br>';
                    echo 'Password: admin123';
                    echo '</p>';
                } else {
                    echo '<div class="status error"><span class="icon">✗</span> Default admin account not found</div>';
                }
                
            } catch (Exception $e) {
                echo '<div class="status error"><span class="icon">✗</span> Could not check admin account</div>';
                echo '<p style="color: #721c24; margin-top: 1rem;">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            ?>
        </div>
        
        <!-- PHP Info -->
        <div class="test-section">
            <h2>5. PHP Configuration</h2>
            <div class="info-grid">
                <div class="info-row"><span class="info-label">PHP Version:</span><span class="info-value"><?php echo phpversion(); ?></span></div>
                <div class="info-row"><span class="info-label">PDO MySQL:</span><span class="info-value"><?php echo extension_loaded('pdo_mysql') ? '✓ Installed' : '✗ Not Installed'; ?></span></div>
                <div class="info-row"><span class="info-label">Session Support:</span><span class="info-value"><?php echo extension_loaded('session') ? '✓ Enabled' : '✗ Disabled'; ?></span></div>
                <div class="info-row"><span class="info-label">File Uploads:</span><span class="info-value"><?php echo ini_get('file_uploads') ? '✓ Enabled' : '✗ Disabled'; ?></span></div>
                <div class="info-row"><span class="info-label">Max Upload Size:</span><span class="info-value"><?php echo ini_get('upload_max_filesize'); ?></span></div>
            </div>
        </div>
        
        <div style="margin-top: 2rem; text-align: center;">
            <a href="index.php" class="btn">Go to Admin Login</a>
            <a href="../index.html" class="btn" style="background: #6c757d; margin-left: 1rem;">Back to Website</a>
        </div>
        
        <p style="text-align: center; margin-top: 2rem; color: #6c757d; font-size: 0.9rem;">
            For setup instructions, see: <code>admin/SETUP_GUIDE.md</code>
        </p>
    </div>
</body>
</html>

