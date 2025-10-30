<?php
/**
 * Application Submission Handler
 * 
 * Processes job application form submissions from apply.html
 */

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/id-generator.php';
require_once __DIR__ . '/../utils/validation.php';
require_once __DIR__ . '/../utils/file-upload.php';

header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Skip CSRF validation for now (can be enabled later)
    // if (!isset($_POST['csrf_token']) || !Validator::validateCSRFToken($_POST['csrf_token'])) {
    //     throw new Exception('Invalid security token. Please refresh the page and try again.');
    // }
    
    // Collect form data
    $data = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'department' => $_POST['department'] ?? '',
        'region' => $_POST['region'] ?? '',
        'position' => $_POST['position'] ?? '',
        'cover_letter' => $_POST['cover-letter'] ?? '',
        'qualifications' => $_POST['qualifications'] ?? ''
    ];
    
    // Validation
    $errors = [];
    
    if (!Validator::required($data['name'])) {
        $errors[] = 'Full name is required';
    }
    
    if (!Validator::validateEmail($data['email'])) {
        $errors[] = 'Valid email address is required';
    }
    
    if (!empty($data['phone']) && !Validator::validatePhone($data['phone'])) {
        $errors[] = 'Valid phone number is required';
    }
    
    if (!Validator::required($data['department'])) {
        $errors[] = 'Department is required';
    }
    
    if (!Validator::required($data['region'])) {
        $errors[] = 'Region is required';
    }
    
    if (!Validator::required($data['position'])) {
        $errors[] = 'Position is required';
    }
    
    if (!Validator::required($data['cover_letter']) || !Validator::minLength($data['cover_letter'], 50)) {
        $errors[] = 'Cover letter must be at least 50 characters';
    }
    
    if (!Validator::required($data['qualifications'])) {
        $errors[] = 'Qualifications are required';
    }
    
    // Check if CV was uploaded
    if (!isset($_FILES['cv']) || $_FILES['cv']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = 'CV/Resume is required';
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
        if ($key !== 'cover_letter' && $key !== 'qualifications') {
            $data[$key] = Validator::sanitizeString($value);
        }
    }
    
    // Generate application ID
    $applicationId = IDGenerator::generateApplicationId();
    
    // Handle CV upload
    $uploader = new FileUploader();
    $uploadResult = $uploader->upload($_FILES['cv'], 'application', $applicationId);
    
    if (!$uploadResult['success']) {
        throw new Exception($uploadResult['error']);
    }
    
    // Begin transaction
    Database::beginTransaction();
    
    try {
        // Insert application into database
        $sql = "INSERT INTO applications 
                (id, applicant_name, email, phone, position, department, region, 
                 cv_file_path, cover_letter, qualifications, date_submitted, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'pending')";
        
        Database::execute($sql, [
            $applicationId,
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['position'],
            $data['department'],
            $data['region'],
            $uploadResult['file_path'],
            $data['cover_letter'],
            $data['qualifications']
        ]);
        
        // Log activity
        $activitySql = "INSERT INTO activity_logs (type, message, status, related_id, timestamp) 
                        VALUES ('application', ?, 'pending', ?, NOW())";
        
        Database::execute($activitySql, [
            "New application received from {$data['name']} for {$data['position']}",
            $applicationId
        ]);
        
        // Commit transaction
        Database::commit();
        
        // TODO: Send confirmation email to applicant
        // sendApplicationConfirmationEmail($data['email'], $data['name'], $applicationId);
        
        // Success response
        echo json_encode([
            'success' => true,
            'message' => 'Application submitted successfully!',
            'application_id' => $applicationId
        ]);
        
    } catch (Exception $e) {
        Database::rollback();
        throw $e;
    }
    
} catch (Exception $e) {
    error_log("Application submission error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while submitting your application. Please try again.',
        'error' => $e->getMessage()
    ]);
}
?>

