<?php
/**
 * Authentication API
 * 
 * Handles login and authentication operations
 */

session_start();

require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? 'login';

try {
    switch ($action) {
        case 'login':
            login();
            break;
            
        case 'logout':
            logout();
            break;
            
        case 'check':
            checkAuth();
            break;
            
        case 'change_password':
            changePassword();
            break;
            
        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
} catch (Exception $e) {
    error_log("Auth API error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

/**
 * Handle login
 */
function login() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        return;
    }
    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        echo json_encode([
            'success' => false,
            'message' => 'Email and password are required'
        ]);
        return;
    }
    
    // Get user from database
    $sql = "SELECT * FROM admin_users WHERE email = ? AND is_active = TRUE";
    $result = Database::query($sql, [$email]);
    
    if (empty($result)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email or password'
        ]);
        return;
    }
    
    $user = $result[0];
    
    // Verify password
    if (!password_verify($password, $user['password_hash'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email or password'
        ]);
        return;
    }
    
    // Set session variables
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_email'] = $user['email'];
    $_SESSION['admin_name'] = $user['full_name'];
    $_SESSION['admin_role'] = $user['role'];
    
    // Update last login
    $updateSql = "UPDATE admin_users SET last_login = NOW() WHERE id = ?";
    Database::execute($updateSql, [$user['id']]);
    
    // Log activity
    $activitySql = "INSERT INTO activity_logs (type, message, status, admin_email, timestamp) 
                    VALUES ('system', ?, 'success', ?, NOW())";
    Database::execute($activitySql, [
        "Admin {$user['email']} logged in",
        $user['email']
    ]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'user' => [
            'email' => $user['email'],
            'name' => $user['full_name'],
            'role' => $user['role']
        ]
    ]);
}

/**
 * Handle logout
 */
function logout() {
    $email = $_SESSION['admin_email'] ?? null;
    
    // Log activity before destroying session
    if ($email) {
        $activitySql = "INSERT INTO activity_logs (type, message, status, admin_email, timestamp) 
                        VALUES ('system', ?, 'success', ?, NOW())";
        Database::execute($activitySql, [
            "Admin {$email} logged out",
            $email
        ]);
    }
    
    session_unset();
    session_destroy();
    
    echo json_encode([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);
}

/**
 * Check authentication status
 */
function checkAuth() {
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        echo json_encode([
            'success' => true,
            'authenticated' => true,
            'user' => [
                'email' => $_SESSION['admin_email'] ?? '',
                'name' => $_SESSION['admin_name'] ?? '',
                'role' => $_SESSION['admin_role'] ?? 'admin'
            ]
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'authenticated' => false
        ]);
    }
}

/**
 * Change password
 */
function changePassword() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        return;
    }
    
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        return;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $currentPassword = $data['current_password'] ?? '';
    $newPassword = $data['new_password'] ?? '';
    $confirmPassword = $data['confirm_password'] ?? '';
    
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo json_encode([
            'success' => false,
            'message' => 'All fields are required'
        ]);
        return;
    }
    
    if ($newPassword !== $confirmPassword) {
        echo json_encode([
            'success' => false,
            'message' => 'New passwords do not match'
        ]);
        return;
    }
    
    if (strlen($newPassword) < 8) {
        echo json_encode([
            'success' => false,
            'message' => 'Password must be at least 8 characters'
        ]);
        return;
    }
    
    // Get current user
    $sql = "SELECT * FROM admin_users WHERE email = ?";
    $result = Database::query($sql, [$_SESSION['admin_email']]);
    
    if (empty($result)) {
        echo json_encode([
            'success' => false,
            'message' => 'User not found'
        ]);
        return;
    }
    
    $user = $result[0];
    
    // Verify current password
    if (!password_verify($currentPassword, $user['password_hash'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Current password is incorrect'
        ]);
        return;
    }
    
    // Hash new password
    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    
    // Update password
    $updateSql = "UPDATE admin_users SET password_hash = ? WHERE id = ?";
    Database::execute($updateSql, [$newPasswordHash, $user['id']]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Password changed successfully'
    ]);
}
?>

