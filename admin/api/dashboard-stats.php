<?php
/**
 * Dashboard Statistics API
 * 
 * Provides real-time statistics for the admin dashboard
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

$action = $_GET['action'] ?? 'overview';

try {
    switch ($action) {
        case 'overview':
            getOverviewStats();
            break;
            
        case 'activity':
            getRecentActivity();
            break;
            
        case 'donations_chart':
            getDonationsChartData();
            break;
            
        case 'applications_chart':
            getApplicationsChartData();
            break;
            
        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
} catch (Exception $e) {
    error_log("Dashboard Stats API error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

/**
 * Get overview statistics for dashboard
 */
function getOverviewStats() {
    // Get all stats in one query using subqueries
    $sql = "SELECT 
                (SELECT COUNT(*) FROM applications) as total_applications,
                (SELECT COUNT(*) FROM applications WHERE status = 'pending') as pending_applications,
                (SELECT COUNT(*) FROM applications WHERE status = 'approved') as approved_applications,
                (SELECT COALESCE(SUM(amount), 0) FROM donations WHERE status = 'Success') as total_donations,
                (SELECT COUNT(*) FROM donations WHERE status = 'Success') as total_donations_count,
                (SELECT COUNT(*) FROM subscriptions WHERE status = 'Active') as active_subscriptions,
                (SELECT COUNT(*) FROM subscriptions) as total_subscriptions";
    
    $stats = Database::query($sql);
    
    echo json_encode([
        'success' => true,
        'data' => $stats[0]
    ]);
}

/**
 * Get recent activity feed
 */
function getRecentActivity() {
    $limit = intval($_GET['limit'] ?? 10);
    
    $sql = "SELECT type, message, status, timestamp 
            FROM activity_logs 
            ORDER BY timestamp DESC 
            LIMIT ?";
    
    $activities = Database::query($sql, [$limit]);
    
    echo json_encode([
        'success' => true,
        'data' => $activities
    ]);
}

/**
 * Get donations chart data (last 6 months)
 */
function getDonationsChartData() {
    $sql = "SELECT 
                DATE_FORMAT(date, '%b') as month,
                DATE_FORMAT(date, '%Y-%m') as year_month,
                COALESCE(SUM(amount), 0) as total_amount,
                COUNT(*) as count
            FROM donations
            WHERE status = 'Success'
                AND date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY year_month, month
            ORDER BY year_month";
    
    $data = Database::query($sql);
    
    // Ensure we have 6 months of data (fill missing months with 0)
    $months = [];
    for ($i = 5; $i >= 0; $i--) {
        $monthDate = date('Y-m', strtotime("-{$i} months"));
        $monthName = date('M', strtotime("-{$i} months"));
        
        $found = false;
        foreach ($data as $row) {
            if ($row['year_month'] === $monthDate) {
                $months[] = [
                    'month' => $monthName,
                    'amount' => floatval($row['total_amount']),
                    'count' => intval($row['count'])
                ];
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $months[] = [
                'month' => $monthName,
                'amount' => 0,
                'count' => 0
            ];
        }
    }
    
    echo json_encode([
        'success' => true,
        'data' => $months
    ]);
}

/**
 * Get applications chart data (by department)
 */
function getApplicationsChartData() {
    $sql = "SELECT 
                department,
                COUNT(*) as count,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
            FROM applications
            GROUP BY department
            ORDER BY count DESC";
    
    $data = Database::query($sql);
    
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
}
?>

