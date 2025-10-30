<?php
/**
 * Donations API
 * 
 * Handles CRUD operations for donations in admin panel
 */

session_start();

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? 'list';

try {
    switch ($action) {
        case 'list':
            getDonations();
            break;
            
        case 'view':
            getDonationById();
            break;
            
        case 'update_status':
            updateDonationStatus();
            break;
            
        case 'send_thank_you':
            sendThankYouEmail();
            break;
            
        case 'export':
            exportDonations();
            break;
            
        case 'stats':
            getDonationStats();
            break;
            
        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
} catch (Exception $e) {
    error_log("Donations API error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

/**
 * Get list of donations with filtering and pagination
 */
function getDonations() {
    $page = intval($_GET['page'] ?? 1);
    $perPage = intval($_GET['per_page'] ?? 10);
    $offset = ($page - 1) * $perPage;
    
    // Filters
    $status = $_GET['status'] ?? '';
    $paymentMethod = $_GET['payment_method'] ?? '';
    $search = $_GET['search'] ?? '';
    $sortBy = $_GET['sort_by'] ?? 'date';
    $sortOrder = $_GET['sort_order'] ?? 'DESC';
    
    // Build WHERE clause
    $where = [];
    $params = [];
    
    if (!empty($status)) {
        $where[] = "status = ?";
        $params[] = $status;
    }
    
    if (!empty($paymentMethod)) {
        $where[] = "payment_method = ?";
        $params[] = $paymentMethod;
    }
    
    if (!empty($search)) {
        $where[] = "(donor_name LIKE ? OR email LIKE ? OR transaction_id LIKE ?)";
        $searchTerm = "%{$search}%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }
    
    $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
    
    // Validate sort column
    $allowedSort = ['id', 'donor_name', 'amount', 'payment_method', 'date', 'status'];
    if (!in_array($sortBy, $allowedSort)) {
        $sortBy = 'date';
    }
    
    $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';
    
    // Get total count
    $countSql = "SELECT COUNT(*) as total FROM donations {$whereClause}";
    $countResult = Database::query($countSql, $params);
    $total = $countResult[0]['total'];
    
    // Get donations
    $sql = "SELECT id, donor_name, email, phone, amount, payment_method, 
                   transaction_id, partner_id, date, status, confirmation_sent
            FROM donations 
            {$whereClause}
            ORDER BY {$sortBy} {$sortOrder}
            LIMIT ? OFFSET ?";
    
    $params[] = $perPage;
    $params[] = $offset;
    
    $donations = Database::query($sql, $params);
    
    echo json_encode([
        'success' => true,
        'data' => $donations,
        'pagination' => [
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ]
    ]);
}

/**
 * Get single donation by ID
 */
function getDonationById() {
    $id = $_GET['id'] ?? '';
    
    if (empty($id)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Donation ID required']);
        return;
    }
    
    $sql = "SELECT * FROM donations WHERE id = ?";
    $result = Database::query($sql, [$id]);
    
    if (empty($result)) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Donation not found']);
        return;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $result[0]
    ]);
}

/**
 * Update donation status
 */
function updateDonationStatus() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        return;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id = $data['id'] ?? '';
    $status = $data['status'] ?? '';
    
    if (empty($id) || !in_array($status, ['Success', 'Pending', 'Failed'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        return;
    }
    
    Database::beginTransaction();
    
    try {
        $sql = "UPDATE donations SET status = ? WHERE id = ?";
        Database::execute($sql, [$status, $id]);
        
        // Log activity
        $activitySql = "INSERT INTO activity_logs (type, message, status, related_id, admin_email, timestamp) 
                        VALUES ('donation', ?, 'success', ?, ?, NOW())";
        
        Database::execute($activitySql, [
            "Donation {$id} status changed to {$status}",
            $id,
            $_SESSION['admin_email']
        ]);
        
        Database::commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Donation status updated successfully'
        ]);
        
    } catch (Exception $e) {
        Database::rollback();
        throw $e;
    }
}

/**
 * Send thank you email
 */
function sendThankYouEmail() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        return;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? '';
    
    if (empty($id)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Donation ID required']);
        return;
    }
    
    // Get donation details
    $sql = "SELECT * FROM donations WHERE id = ?";
    $result = Database::query($sql, [$id]);
    
    if (empty($result)) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Donation not found']);
        return;
    }
    
    $donation = $result[0];
    
    // TODO: Send actual email
    // sendDonationThankYouEmail($donation['email'], $donation['donor_name'], $donation['partner_id'], $donation['amount']);
    
    // Update confirmation_sent flag
    $updateSql = "UPDATE donations SET confirmation_sent = TRUE, partner_email_sent = TRUE WHERE id = ?";
    Database::execute($updateSql, [$id]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Thank you email sent successfully'
    ]);
}

/**
 * Export donations to Excel/CSV
 */
function exportDonations() {
    $status = $_GET['status'] ?? '';
    
    $where = [];
    $params = [];
    
    if (!empty($status)) {
        $where[] = "status = ?";
        $params[] = $status;
    }
    
    $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
    
    $sql = "SELECT id, donor_name, email, phone, amount, payment_method, 
                   transaction_id, partner_id, date, status
            FROM donations 
            {$whereClause}
            ORDER BY date DESC";
    
    $donations = Database::query($sql, $params);
    
    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="donations_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // CSV headers
    fputcsv($output, ['ID', 'Donor Name', 'Email', 'Phone', 'Amount (UGX)', 'Payment Method', 'Transaction ID', 'Partner ID', 'Date', 'Status']);
    
    // CSV rows
    foreach ($donations as $donation) {
        fputcsv($output, $donation);
    }
    
    fclose($output);
    exit;
}

/**
 * Get donation statistics
 */
function getDonationStats() {
    $sql = "SELECT 
                COUNT(*) as total_count,
                SUM(CASE WHEN status = 'Success' THEN 1 ELSE 0 END) as success_count,
                COALESCE(SUM(CASE WHEN status = 'Success' THEN amount ELSE 0 END), 0) as total_amount,
                COALESCE(AVG(CASE WHEN status = 'Success' THEN amount ELSE NULL END), 0) as average_amount
            FROM donations";
    
    $stats = Database::query($sql);
    
    echo json_encode([
        'success' => true,
        'data' => $stats[0]
    ]);
}
?>

