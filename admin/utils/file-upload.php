<?php
/**
 * File Upload Utility
 * 
 * Handles secure file uploads for CVs and documents
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/validation.php';

class FileUploader {
    
    private $uploadDir;
    private $maxFileSize;
    private $allowedMimeTypes;
    
    /**
     * Constructor
     * 
     * @param string $uploadDir Upload directory path
     * @param int $maxFileSize Maximum file size in bytes (default: 5MB)
     * @param array $allowedMimeTypes Allowed MIME types
     */
    public function __construct($uploadDir = null, $maxFileSize = 5242880, $allowedMimeTypes = null) {
        $this->uploadDir = $uploadDir ?? __DIR__ . '/../../uploads/cvs/';
        $this->maxFileSize = $maxFileSize;
        $this->allowedMimeTypes = $allowedMimeTypes ?? [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
        
        // Create upload directory if it doesn't exist
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
        
        // Create .htaccess to prevent direct access to uploaded files
        $htaccessPath = $this->uploadDir . '.htaccess';
        if (!file_exists($htaccessPath)) {
            file_put_contents($htaccessPath, "deny from all");
        }
    }
    
    /**
     * Upload file
     * 
     * @param array $file $_FILES array element
     * @param string $relatedType Type of related record (application, donation, etc.)
     * @param string $relatedId ID of related record
     * @return array ['success' => bool, 'file_path' => string, 'error' => string]
     */
    public function upload($file, $relatedType = null, $relatedId = null) {
        $result = ['success' => false, 'file_path' => null, 'error' => ''];
        
        // Validate file
        $validation = Validator::validateFile($file, $this->allowedMimeTypes, $this->maxFileSize);
        if (!$validation['valid']) {
            $result['error'] = $validation['error'];
            return $result;
        }
        
        // Generate unique filename
        $originalFilename = basename($file['name']);
        $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
        $storedFilename = $this->generateUniqueFilename($extension);
        $filePath = $this->uploadDir . $storedFilename;
        
        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            $result['error'] = 'Failed to move uploaded file';
            return $result;
        }
        
        // Get MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);
        
        // Log upload to database
        try {
            $sql = "INSERT INTO file_uploads 
                    (original_filename, stored_filename, file_path, file_size, mime_type, related_type, related_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            Database::execute($sql, [
                $originalFilename,
                $storedFilename,
                $filePath,
                $file['size'],
                $mimeType,
                $relatedType,
                $relatedId
            ]);
            
        } catch (Exception $e) {
            // Log error but don't fail the upload
            error_log("Failed to log file upload: " . $e->getMessage());
        }
        
        $result['success'] = true;
        $result['file_path'] = $filePath;
        $result['stored_filename'] = $storedFilename;
        
        return $result;
    }
    
    /**
     * Generate unique filename
     * 
     * @param string $extension File extension
     * @return string Unique filename
     */
    private function generateUniqueFilename($extension) {
        return uniqid('file_', true) . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
    }
    
    /**
     * Delete file
     * 
     * @param string $filePath File path to delete
     * @return bool True if deleted
     */
    public function delete($filePath) {
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
    
    /**
     * Get file by stored filename
     * 
     * @param string $storedFilename Stored filename
     * @return array File info from database
     */
    public static function getFileInfo($storedFilename) {
        $sql = "SELECT * FROM file_uploads WHERE stored_filename = ?";
        $result = Database::query($sql, [$storedFilename]);
        return !empty($result) ? $result[0] : null;
    }
    
    /**
     * Serve file for download (with permission check)
     * 
     * @param string $storedFilename Stored filename
     * @param bool $inline Display inline or download
     */
    public static function serveFile($storedFilename, $inline = false) {
        $fileInfo = self::getFileInfo($storedFilename);
        
        if (!$fileInfo || !file_exists($fileInfo['file_path'])) {
            http_response_code(404);
            die('File not found');
        }
        
        // Set headers
        header('Content-Type: ' . $fileInfo['mime_type']);
        header('Content-Length: ' . $fileInfo['file_size']);
        
        if ($inline) {
            header('Content-Disposition: inline; filename="' . $fileInfo['original_filename'] . '"');
        } else {
            header('Content-Disposition: attachment; filename="' . $fileInfo['original_filename'] . '"');
        }
        
        // Output file
        readfile($fileInfo['file_path']);
        exit;
    }
}
?>

