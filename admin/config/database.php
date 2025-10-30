<?php
/**
 * Database Configuration for Elpis Initiative Uganda
 * 
 * This file contains database connection settings and provides
 * a singleton PDO connection instance for the entire application.
 */

// Database credentials
define('DB_HOST', '193.203.184.226');
define('DB_NAME', 'u508604795_elpis');
define('DB_USER', 'u508604795_elpis');  // Change this to your MySQL username
define('DB_PASS', 'Sr&9wDtIKo');      // Change this to your MySQL password
define('DB_CHARSET', 'utf8mb4');

/**
 * Database class - Singleton pattern for PDO connection
 */
class Database {
    private static $connection = null;
    
    /**
     * Get database connection instance
     * 
     * @return PDO Database connection
     * @throws PDOException If connection fails
     */
    public static function getConnection() {
        if (self::$connection === null) {
            try {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
                
                self::$connection = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
                ]);
                
            } catch(PDOException $e) {
                error_log("Database Connection Error: " . $e->getMessage());
                throw new Exception("Database connection failed. Please try again later.");
            }
        }
        
        return self::$connection;
    }
    
    /**
     * Execute a query and return results
     * 
     * @param string $sql SQL query
     * @param array $params Parameters for prepared statement
     * @return array Query results
     */
    public static function query($sql, $params = []) {
        $conn = self::getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Execute an insert/update/delete query
     * 
     * @param string $sql SQL query
     * @param array $params Parameters for prepared statement
     * @return int Number of affected rows
     */
    public static function execute($sql, $params = []) {
        $conn = self::getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
    
    /**
     * Get last inserted ID
     * 
     * @return string Last insert ID
     */
    public static function lastInsertId() {
        return self::getConnection()->lastInsertId();
    }
    
    /**
     * Begin transaction
     */
    public static function beginTransaction() {
        return self::getConnection()->beginTransaction();
    }
    
    /**
     * Commit transaction
     */
    public static function commit() {
        return self::getConnection()->commit();
    }
    
    /**
     * Rollback transaction
     */
    public static function rollback() {
        return self::getConnection()->rollBack();
    }
}

/**
 * Helper function to test database connection
 * 
 * @return bool True if connection successful
 */
function testDatabaseConnection() {
    try {
        $conn = Database::getConnection();
        return $conn !== null;
    } catch (Exception $e) {
        return false;
    }
}
?>

