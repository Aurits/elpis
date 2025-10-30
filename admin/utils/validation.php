<?php
/**
 * Validation Utility
 * 
 * Provides validation functions for user input
 */

class Validator {
    
    /**
     * Validate email address
     * 
     * @param string $email Email to validate
     * @return bool True if valid
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Validate Ugandan phone number
     * Accepts formats: +256700123456, 0700123456, 256700123456
     * 
     * @param string $phone Phone number to validate
     * @return bool True if valid
     */
    public static function validatePhone($phone) {
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Check various formats
        $patterns = [
            '/^\+256[7][0-9]{8}$/',      // +256700123456
            '/^256[7][0-9]{8}$/',         // 256700123456
            '/^0[7][0-9]{8}$/',           // 0700123456
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $phone)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Normalize phone number to +256 format
     * 
     * @param string $phone Phone number
     * @return string Normalized phone number
     */
    public static function normalizePhone($phone) {
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Already in correct format
        if (preg_match('/^\+256[7][0-9]{8}$/', $phone)) {
            return $phone;
        }
        
        // 256700123456 -> +256700123456
        if (preg_match('/^256[7][0-9]{8}$/', $phone)) {
            return '+' . $phone;
        }
        
        // 0700123456 -> +256700123456
        if (preg_match('/^0[7][0-9]{8}$/', $phone)) {
            return '+256' . substr($phone, 1);
        }
        
        return $phone;
    }
    
    /**
     * Sanitize string input
     * 
     * @param string $input Input to sanitize
     * @return string Sanitized input
     */
    public static function sanitizeString($input) {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Validate required field
     * 
     * @param mixed $value Value to check
     * @return bool True if not empty
     */
    public static function required($value) {
        if (is_string($value)) {
            return trim($value) !== '';
        }
        return !empty($value);
    }
    
    /**
     * Validate minimum length
     * 
     * @param string $value String to check
     * @param int $min Minimum length
     * @return bool True if meets minimum
     */
    public static function minLength($value, $min) {
        return strlen(trim($value)) >= $min;
    }
    
    /**
     * Validate maximum length
     * 
     * @param string $value String to check
     * @param int $max Maximum length
     * @return bool True if within maximum
     */
    public static function maxLength($value, $max) {
        return strlen(trim($value)) <= $max;
    }
    
    /**
     * Validate numeric value
     * 
     * @param mixed $value Value to check
     * @return bool True if numeric
     */
    public static function isNumeric($value) {
        return is_numeric($value);
    }
    
    /**
     * Validate minimum value
     * 
     * @param numeric $value Value to check
     * @param numeric $min Minimum value
     * @return bool True if greater than or equal to minimum
     */
    public static function minValue($value, $min) {
        return is_numeric($value) && $value >= $min;
    }
    
    /**
     * Validate file upload
     * 
     * @param array $file $_FILES array element
     * @param array $allowedTypes Allowed MIME types
     * @param int $maxSize Maximum file size in bytes
     * @return array ['valid' => bool, 'error' => string]
     */
    public static function validateFile($file, $allowedTypes, $maxSize) {
        $result = ['valid' => true, 'error' => ''];
        
        // Check if file was uploaded
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            $result['valid'] = false;
            $result['error'] = 'File upload failed';
            return $result;
        }
        
        // Check file size
        if ($file['size'] > $maxSize) {
            $result['valid'] = false;
            $result['error'] = 'File size exceeds maximum allowed (' . self::formatBytes($maxSize) . ')';
            return $result;
        }
        
        // Check MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $allowedTypes)) {
            $result['valid'] = false;
            $result['error'] = 'Invalid file type. Allowed types: ' . implode(', ', $allowedTypes);
            return $result;
        }
        
        return $result;
    }
    
    /**
     * Format bytes to human readable
     * 
     * @param int $bytes Bytes
     * @return string Formatted size
     */
    private static function formatBytes($bytes) {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
    
    /**
     * Validate CSRF token
     * 
     * @param string $token Token to validate
     * @return bool True if valid
     */
    public static function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Generate CSRF token
     * 
     * @return string CSRF token
     */
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}
?>

