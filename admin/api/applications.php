<?php
/**
 * Applications API
 * 
 * Handles CRUD operations for job applications in admin panel
 */

session_start();

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/validation.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? 'list';

try {
    switch ($action) {
        case 'list':
            getApplications();
            break;
            
        case 'view':
            getApplicationById();
            break;
            
        case 'update_status':
            updateApplicationStatus();
            break;
            
        case 'delete':
            deleteApplication();
            break;
            
        case 'export':
            exportApplications();
            break;
            
        case 'stats':
            getApplicationStats();
            break;
            
        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
} catch (Exception $e) {
    error_log("Applications API error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

/**
 * Get list of applications with filtering and pagination
 */
function getApplications() {
    $page = intval($_GET['page'] ?? 1);
    $perPage = intval($_GET['per_page'] ?? 10);
    $offset = ($page - 1) * $perPage;
    
    // Filters
    $status = $_GET['status'] ?? '';
    $department = $_GET['department'] ?? '';
    $region = $_GET['region'] ?? '';
    $search = $_GET['search'] ?? '';
    $sortBy = $_GET['sort_by'] ?? 'date_submitted';
    $sortOrder = $_GET['sort_order'] ?? 'DESC';
    
    // Build WHERE clause
    $where = [];
    $params = [];
    
    if (!empty($status)) {
        $where[] = "status = ?";
        $params[] = $status;
    }
    
    if (!empty($department)) {
        $where[] = "department = ?";
        $params[] = $department;
    }
    
    if (!empty($region)) {
        $where[] = "region = ?";
        $params[] = $region;
    }
    
    if (!empty($search)) {
        $where[] = "(applicant_name LIKE ? OR email LIKE ? OR position LIKE ?)";
        $searchTerm = "%{$search}%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }
    
    $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
    
    // Validate sort column
    $allowedSort = ['id', 'applicant_name', 'position', 'department', 'region', 'date_submitted', 'status'];
    if (!in_array($sortBy, $allowedSort)) {
        $sortBy = 'date_submitted';
    }
    
    $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';
    
    // Get total count
    $countSql = "SELECT COUNT(*) as total FROM applications {$whereClause}";
    $countResult = Database::query($countSql, $params);
    $total = $countResult[0]['total'];
    
    // Get applications
    $sql = "SELECT id, applicant_name, email, phone, position, department, region, 
                   date_submitted, status, reviewed_by, reviewed_at
            FROM applications 
            {$whereClause}
            ORDER BY {$sortBy} {$sortOrder}
            LIMIT ? OFFSET ?";
    
    $params[] = $perPage;
    $params[] = $offset;
    
    $applications = Database::query($sql, $params);
    
    echo json_encode([
        'success' => true,
        'data' => $applications,
        'pagination' => [
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ]
    ]);
}

/**
 * Get single application by ID
 */
function getApplicationById() {
    $id = $_GET['id'] ?? '';
    
    if (empty($id)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Application ID required']);
        return;
    }
    
    $sql = "SELECT * FROM applications WHERE id = ?";
    $result = Database::query($sql, [$id]);
    
    if (empty($result)) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Application not found']);
        return;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $result[0]
    ]);
}

/**
 * Update application status
 */
function updateApplicationStatus() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        return;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id = $data['id'] ?? '';
    $status = $data['status'] ?? '';
    $notes = $data['notes'] ?? '';
    
    if (empty($id) || !in_array($status, ['pending', 'approved', 'rejected'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        return;
    }
    
    Database::beginTransaction();
    
    try {
        $sql = "UPDATE applications 
                SET status = ?, 
                    reviewed_by = ?, 
                    reviewed_at = NOW(),
                    notes = ?
                WHERE id = ?";
        
        Database::execute($sql, [$status, $_SESSION['admin_email'], $notes, $id]);
        
        // Log activity
        $activitySql = "INSERT INTO activity_logs (type, message, status, related_id, admin_email, timestamp) 
                        VALUES ('application', ?, 'success', ?, ?, NOW())";
        
        Database::execute($activitySql, [
            "Application {$id} status changed to {$status}",
            $id,
            $_SESSION['admin_email']
        ]);
        
        Database::commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Application status updated successfully'
        ]);
        
    } catch (Exception $e) {
        Database::rollback();
        throw $e;
    }
}

/**
 * Delete application
 */
function deleteApplication() {
    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        return;
    }
    
    $id = $_GET['id'] ?? '';
    
    if (empty($id)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Application ID required']);
        return;
    }
    
    Database::beginTransaction();
    
    try {
        // Get CV file path before deleting
        $sql = "SELECT cv_file_path FROM applications WHERE id = ?";
        $result = Database::query($sql, [$id]);
        
        if (!empty($result) && !empty($result[0]['cv_file_path'])) {
            $cvPath = $result[0]['cv_file_path'];
            if (file_exists($cvPath)) {
                unlink($cvPath);
            }
        }
        
        // Delete application
        $deleteSql = "DELETE FROM applications WHERE id = ?";
        Database::execute($deleteSql, [$id]);
        
        // Log activity
        $activitySql = "INSERT INTO activity_logs (type, message, status, admin_email, timestamp) 
                        VALUES ('application', ?, 'success', ?, NOW())";
        
        Database::execute($activitySql, [
            "Application {$id} deleted",
            $_SESSION['admin_email']
        ]);
        
        Database::commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Application deleted successfully'
        ]);
        
    } catch (Exception $e) {
        Database::rollback();
        throw $e;
    }
}

/**
 * Export applications to CSV
 */
function exportApplications() {
    $status = $_GET['status'] ?? '';
    
    $where = [];
    $params = [];
    
    if (!empty($status)) {
        $where[] = "status = ?";
        $params[] = $status;
    }
    
    $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
    
    $sql = "SELECT id, applicant_name, email, phone, position, department, region, 
                   date_submitted, status
            FROM applications 
            {$whereClause}
            ORDER BY date_submitted DESC";
    
    $applications = Database::query($sql, $params);
    
    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="applications_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // CSV headers
    fputcsv($output, ['ID', 'Applicant Name', 'Email', 'Phone', 'Position', 'Department', 'Region', 'Date Submitted', 'Status']);
    
    // CSV rows
    foreach ($applications as $app) {
        fputcsv($output, $app);
    }
    
    fclose($output);
    exit;
}

/**
 * Get application statistics
 */
function getApplicationStats() {
    $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
            FROM applications";
    
    $stats = Database::query($sql);
    
    echo json_encode([
        'success' => true,
        'data' => $stats[0]
    ]);
}
?>

