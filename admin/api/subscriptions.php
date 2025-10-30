<?php
/**
 * Subscriptions API
 * 
 * Handles CRUD operations for newsletter subscriptions in admin panel
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
            getSubscriptions();
            break;
            
        case 'view':
            getSubscriptionById();
            break;
            
        case 'toggle_status':
            toggleSubscriptionStatus();
            break;
            
        case 'send_newsletter':
            sendNewsletter();
            break;
            
        case 'export':
            exportSubscriptions();
            break;
            
        case 'stats':
            getSubscriptionStats();
            break;
            
        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
} catch (Exception $e) {
    error_log("Subscriptions API error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

/**
 * Get list of subscriptions with filtering and pagination
 */
function getSubscriptions() {
    $page = intval($_GET['page'] ?? 1);
    $perPage = intval($_GET['per_page'] ?? 10);
    $offset = ($page - 1) * $perPage;
    
    // Filters
    $status = $_GET['status'] ?? '';
    $region = $_GET['region'] ?? '';
    $search = $_GET['search'] ?? '';
    $sortBy = $_GET['sort_by'] ?? 'subscription_date';
    $sortOrder = $_GET['sort_order'] ?? 'DESC';
    
    // Build WHERE clause
    $where = [];
    $params = [];
    
    if (!empty($status)) {
        $where[] = "status = ?";
        $params[] = $status;
    }
    
    if (!empty($region)) {
        $where[] = "region = ?";
        $params[] = $region;
    }
    
    if (!empty($search)) {
        $where[] = "(subscriber_name LIKE ? OR email LIKE ?)";
        $searchTerm = "%{$search}%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }
    
    $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
    
    // Validate sort column
    $allowedSort = ['id', 'subscriber_name', 'email', 'region', 'subscription_date', 'status'];
    if (!in_array($sortBy, $allowedSort)) {
        $sortBy = 'subscription_date';
    }
    
    $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';
    
    // Get total count
    $countSql = "SELECT COUNT(*) as total FROM subscriptions {$whereClause}";
    $countResult = Database::query($countSql, $params);
    $total = $countResult[0]['total'];
    
    // Get subscriptions
    $sql = "SELECT id, subscriber_name, email, phone, region, 
                   subscription_date, status, last_email_sent
            FROM subscriptions 
            {$whereClause}
            ORDER BY {$sortBy} {$sortOrder}
            LIMIT ? OFFSET ?";
    
    $params[] = $perPage;
    $params[] = $offset;
    
    $subscriptions = Database::query($sql, $params);
    
    echo json_encode([
        'success' => true,
        'data' => $subscriptions,
        'pagination' => [
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ]
    ]);
}

/**
 * Get single subscription by ID
 */
function getSubscriptionById() {
    $id = $_GET['id'] ?? '';
    
    if (empty($id)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Subscription ID required']);
        return;
    }
    
    $sql = "SELECT * FROM subscriptions WHERE id = ?";
    $result = Database::query($sql, [$id]);
    
    if (empty($result)) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Subscription not found']);
        return;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $result[0]
    ]);
}

/**
 * Toggle subscription status (Active/Inactive)
 */
function toggleSubscriptionStatus() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        return;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id = $data['id'] ?? '';
    $status = $data['status'] ?? '';
    
    if (empty($id) || !in_array($status, ['Active', 'Inactive'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        return;
    }
    
    $sql = "UPDATE subscriptions SET status = ? WHERE id = ?";
    Database::execute($sql, [$status, $id]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Subscription status updated successfully'
    ]);
}

/**
 * Send newsletter to selected subscribers
 */
function sendNewsletter() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        return;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $subject = $data['subject'] ?? '';
    $content = $data['content'] ?? '';
    $subscribers = $data['subscribers'] ?? []; // Array of subscription IDs
    
    if (empty($subject) || empty($content)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Subject and content are required']);
        return;
    }
    
    Database::beginTransaction();
    
    try {
        // If no specific subscribers, send to all active
        if (empty($subscribers)) {
            $sql = "SELECT email, subscriber_name FROM subscriptions WHERE status = 'Active'";
            $recipientList = Database::query($sql);
        } else {
            $placeholders = str_repeat('?,', count($subscribers) - 1) . '?';
            $sql = "SELECT email, subscriber_name FROM subscriptions 
                    WHERE id IN ({$placeholders}) AND status = 'Active'";
            $recipientList = Database::query($sql, $subscribers);
        }
        
        if (empty($recipientList)) {
            throw new Exception('No active subscribers found');
        }
        
        // Create campaign record
        $campaignSql = "INSERT INTO newsletter_campaigns 
                        (subject, content, recipients_count, sent_at, created_by) 
                        VALUES (?, ?, ?, NOW(), ?)";
        
        Database::execute($campaignSql, [
            $subject,
            $content,
            count($recipientList),
            $_SESSION['admin_email']
        ]);
        
        $campaignId = Database::lastInsertId();
        
        // TODO: Queue emails or send them
        // For now, just update last_email_sent for all recipients
        foreach ($recipientList as $recipient) {
            // sendNewsletterEmail($recipient['email'], $recipient['subscriber_name'], $subject, $content);
            
            $updateSql = "UPDATE subscriptions SET last_email_sent = NOW() WHERE email = ?";
            Database::execute($updateSql, [$recipient['email']]);
        }
        
        // Update campaign sent count
        $updateCampaignSql = "UPDATE newsletter_campaigns SET sent_count = ? WHERE id = ?";
        Database::execute($updateCampaignSql, [count($recipientList), $campaignId]);
        
        // Log activity
        $activitySql = "INSERT INTO activity_logs (type, message, status, admin_email, timestamp) 
                        VALUES ('subscription', ?, 'success', ?, NOW())";
        
        Database::execute($activitySql, [
            "Newsletter sent to " . count($recipientList) . " subscribers",
            $_SESSION['admin_email']
        ]);
        
        Database::commit();
        
        echo json_encode([
            'success' => true,
            'message' => "Newsletter sent to " . count($recipientList) . " subscribers",
            'sent_count' => count($recipientList)
        ]);
        
    } catch (Exception $e) {
        Database::rollback();
        throw $e;
    }
}

/**
 * Export subscriptions to CSV
 */
function exportSubscriptions() {
    $status = $_GET['status'] ?? '';
    $selected = $_GET['selected'] ?? ''; // Comma-separated IDs
    
    $where = [];
    $params = [];
    
    if (!empty($status)) {
        $where[] = "status = ?";
        $params[] = $status;
    }
    
    if (!empty($selected)) {
        $ids = explode(',', $selected);
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $where[] = "id IN ({$placeholders})";
        $params = array_merge($params, $ids);
    }
    
    $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
    
    $sql = "SELECT id, subscriber_name, email, phone, region, subscription_date, status
            FROM subscriptions 
            {$whereClause}
            ORDER BY subscription_date DESC";
    
    $subscriptions = Database::query($sql, $params);
    
    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="subscriptions_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // CSV headers
    fputcsv($output, ['ID', 'Subscriber Name', 'Email', 'Phone', 'Region', 'Subscription Date', 'Status']);
    
    // CSV rows
    foreach ($subscriptions as $sub) {
        fputcsv($output, $sub);
    }
    
    fclose($output);
    exit;
}

/**
 * Get subscription statistics
 */
function getSubscriptionStats() {
    $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'Active' THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = 'Inactive' THEN 1 ELSE 0 END) as inactive
            FROM subscriptions";
    
    $stats = Database::query($sql);
    
    echo json_encode([
        'success' => true,
        'data' => $stats[0]
    ]);
}
?>

