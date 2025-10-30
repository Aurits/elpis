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
        
        case 'distribution':
            getDistributionData();
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
 * Get donations chart data (last 12 months)
 */
function getDonationsChartData() {
    try {
        $sql = "SELECT 
                    DATE_FORMAT(`date`, '%Y-%m') AS ym,
                    DATE_FORMAT(`date`, '%b') AS month_name,
                    COALESCE(SUM(amount), 0) AS total_amount,
                    COUNT(*) AS total_count
                FROM donations
                WHERE status = 'Success'
                  AND `date` >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
                GROUP BY ym
                ORDER BY ym";

        $rows = Database::query($sql);

        $out = [];
        for ($i = 11; $i >= 0; $i--) {
            $ym = date('Y-m', strtotime("-{$i} months"));
            $label = date('M', strtotime("-{$i} months"));
            $match = array_values(array_filter($rows, function ($r) use ($ym) { return ($r['ym'] ?? '') === $ym; }));
            if (!empty($match)) {
                $row = $match[0];
                $out[] = [
                    'month' => $label,
                    'amount' => (float)($row['total_amount'] ?? 0),
                    'count'  => (int)($row['total_count'] ?? 0),
                ];
            } else {
                $out[] = ['month' => $label, 'amount' => 0, 'count' => 0];
            }
        }

        echo json_encode(['success' => true, 'data' => $out]);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'donations_chart failed', 'error' => $e->getMessage()]);
    }
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

/**
 * Get distribution data for pie chart (by region using subscriptions)
 */
function getDistributionData() {
    // Use subscriptions regions for distribution
    $sql = "SELECT region as name, COUNT(*) as value
            FROM subscriptions
            WHERE region IS NOT NULL AND region <> ''
            GROUP BY region
            ORDER BY value DESC";
    
    $rows = Database::query($sql);
    
    echo json_encode([
        'success' => true,
        'data' => $rows
    ]);
}
?>

