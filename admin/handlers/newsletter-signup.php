<?php
/**
 * Newsletter Signup Handler
 * 
 * Processes newsletter subscription from footer and other forms
 */

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/id-generator.php';
require_once __DIR__ . '/../utils/validation.php';

header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Collect form data
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $region = $_POST['region'] ?? '';
    $source = $_POST['source'] ?? 'footer_form';
    
    // Validation
    if (!Validator::validateEmail($email)) {
        echo json_encode([
            'success' => false,
            'message' => 'Please provide a valid email address'
        ]);
        exit;
    }
    
    // Sanitize inputs
    $email = Validator::sanitizeString($email);
    $name = !empty($name) ? Validator::sanitizeString($name) : '';
    $region = !empty($region) ? Validator::sanitizeString($region) : '';
    
    // Normalize phone if provided
    if (!empty($phone)) {
        if (!Validator::validatePhone($phone)) {
            echo json_encode([
                'success' => false,
                'message' => 'Please provide a valid phone number'
            ]);
            exit;
        }
        $phone = Validator::normalizePhone($phone);
    }
    
    // Check if email already subscribed
    $checkSql = "SELECT id, status FROM subscriptions WHERE email = ?";
    $existing = Database::query($checkSql, [$email]);
    
    if (!empty($existing)) {
        $subscription = $existing[0];
        
        // If inactive, reactivate
        if ($subscription['status'] === 'Inactive') {
            $updateSql = "UPDATE subscriptions 
                         SET status = 'Active', 
                             subscription_date = NOW(),
                             unsubscribed_at = NULL
                         WHERE id = ?";
            
            Database::execute($updateSql, [$subscription['id']]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Welcome back! Your subscription has been reactivated.'
            ]);
        } else {
            echo json_encode([
                'success' => true,
                'message' => 'You are already subscribed to our newsletter!'
            ]);
        }
        exit;
    }
    
    // Generate subscription ID and unsubscribe token
    $subscriptionId = IDGenerator::generateSubscriptionId();
    $unsubscribeToken = IDGenerator::generateUnsubscribeToken($email);
    
    // Begin transaction
    Database::beginTransaction();
    
    try {
        // Insert subscription into database
        $sql = "INSERT INTO subscriptions 
                (id, subscriber_name, email, phone, region, subscription_date, 
                 status, unsubscribe_token, source) 
                VALUES (?, ?, ?, ?, ?, NOW(), 'Active', ?, ?)";
        
        Database::execute($sql, [
            $subscriptionId,
            $name,
            $email,
            $phone,
            $region,
            $unsubscribeToken,
            $source
        ]);
        
        // Log activity
        $activitySql = "INSERT INTO activity_logs (type, message, status, related_id, timestamp) 
                        VALUES ('subscription', ?, 'success', ?, NOW())";
        
        $subscriberName = !empty($name) ? $name : $email;
        Database::execute($activitySql, [
            "New newsletter subscription from {$subscriberName}",
            $subscriptionId
        ]);
        
        // Commit transaction
        Database::commit();
        
        // TODO: Send welcome email
        // sendWelcomeEmail($email, $name, $unsubscribeToken);
        
        // Success response
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for subscribing! Check your email for confirmation.'
        ]);
        
    } catch (Exception $e) {
        Database::rollback();
        throw $e;
    }
    
} catch (Exception $e) {
    error_log("Newsletter signup error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again later.',
        'error' => $e->getMessage()
    ]);
}
?>

