<?php
/**
 * Donation Confirmation Handler
 * 
 * Processes donation confirmation submissions
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
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !Validator::validateCSRFToken($_POST['csrf_token'])) {
        throw new Exception('Invalid security token. Please refresh the page and try again.');
    }
    
    // Collect form data
    $data = [
        'donor_name' => $_POST['donor_name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'amount' => $_POST['amount'] ?? 0,
        'payment_method' => $_POST['payment_method'] ?? '',
        'transaction_id' => $_POST['transaction_id'] ?? '',
        'reference_code' => $_POST['reference_code'] ?? ''
    ];
    
    // Validation
    $errors = [];
    
    if (!Validator::required($data['donor_name'])) {
        $errors[] = 'Donor name is required';
    }
    
    if (!Validator::validateEmail($data['email'])) {
        $errors[] = 'Valid email address is required';
    }
    
    if (!empty($data['phone']) && !Validator::validatePhone($data['phone'])) {
        $errors[] = 'Valid phone number is required';
    }
    
    if (!Validator::minValue($data['amount'], 20000)) {
        $errors[] = 'Minimum donation amount is UGX 20,000';
    }
    
    if (!in_array($data['payment_method'], ['Mobile Money', 'Bank', 'Card'])) {
        $errors[] = 'Valid payment method is required';
    }
    
    if (!Validator::required($data['transaction_id'])) {
        $errors[] = 'Transaction ID is required';
    }
    
    // Return validation errors
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'message' => 'Please fix the following errors',
            'errors' => $errors
        ]);
        exit;
    }
    
    // Normalize phone number
    if (!empty($data['phone'])) {
        $data['phone'] = Validator::normalizePhone($data['phone']);
    }
    
    // Sanitize inputs
    foreach ($data as $key => $value) {
        if ($key !== 'amount') {
            $data[$key] = Validator::sanitizeString($value);
        }
    }
    
    // Check if transaction ID already exists
    $checkSql = "SELECT id FROM donations WHERE transaction_id = ?";
    $existing = Database::query($checkSql, [$data['transaction_id']]);
    
    if (!empty($existing)) {
        echo json_encode([
            'success' => false,
            'message' => 'This transaction has already been recorded.',
            'donation_id' => $existing[0]['id']
        ]);
        exit;
    }
    
    // Generate IDs
    $donationId = IDGenerator::generateDonationId();
    $partnerId = IDGenerator::generatePartnerId();
    
    // Set default reference code if not provided
    if (empty($data['reference_code'])) {
        $data['reference_code'] = '10MILLIONHEARTS-' . explode(' ', $data['donor_name'])[0];
    }
    
    // Begin transaction
    Database::beginTransaction();
    
    try {
        // Insert donation into database
        $sql = "INSERT INTO donations 
                (id, donor_name, email, phone, amount, payment_method, transaction_id, 
                 reference_code, partner_id, date, status, confirmation_sent) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Pending', FALSE)";
        
        Database::execute($sql, [
            $donationId,
            $data['donor_name'],
            $data['email'],
            $data['phone'],
            $data['amount'],
            $data['payment_method'],
            $data['transaction_id'],
            $data['reference_code'],
            $partnerId
        ]);
        
        // Log activity
        $activitySql = "INSERT INTO activity_logs (type, message, status, related_id, timestamp) 
                        VALUES ('donation', ?, 'pending', ?, NOW())";
        
        Database::execute($activitySql, [
            "New donation of UGX " . number_format($data['amount']) . " received from {$data['donor_name']}",
            $donationId
        ]);
        
        // Commit transaction
        Database::commit();
        
        // TODO: Send thank you email with partner ID
        // sendDonationThankYouEmail($data['email'], $data['donor_name'], $partnerId, $data['amount']);
        
        // Success response
        echo json_encode([
            'success' => true,
            'message' => 'Donation confirmed successfully! Your Partner ID will be sent to your email.',
            'donation_id' => $donationId,
            'partner_id' => $partnerId
        ]);
        
    } catch (Exception $e) {
        Database::rollback();
        throw $e;
    }
    
} catch (Exception $e) {
    error_log("Donation confirmation error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while confirming your donation. Please try again.',
        'error' => $e->getMessage()
    ]);
}
?>

