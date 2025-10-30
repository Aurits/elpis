<?php
/**
 * ID Generator Utility
 * 
 * Generates unique IDs for applications, donations, subscriptions, and partner IDs
 */

require_once __DIR__ . '/../config/database.php';

class IDGenerator {
    
    /**
     * Generate next Application ID (Format: APP-0001)
     * 
     * @return string Application ID
     */
    public static function generateApplicationId() {
        try {
            $conn = Database::getConnection();
            $stmt = $conn->query("SELECT get_next_application_id() as next_id");
            $result = $stmt->fetch();
            return $result['next_id'];
        } catch (Exception $e) {
            // Fallback method if function doesn't exist
            $sql = "SELECT id FROM applications ORDER BY id DESC LIMIT 1";
            $result = Database::query($sql);
            
            if (empty($result)) {
                return 'APP-0001';
            }
            
            $lastId = $result[0]['id'];
            $number = intval(substr($lastId, 4)) + 1;
            return 'APP-' . str_pad($number, 4, '0', STR_PAD_LEFT);
        }
    }
    
    /**
     * Generate next Donation ID (Format: DON-00001)
     * 
     * @return string Donation ID
     */
    public static function generateDonationId() {
        try {
            $conn = Database::getConnection();
            $stmt = $conn->query("SELECT get_next_donation_id() as next_id");
            $result = $stmt->fetch();
            return $result['next_id'];
        } catch (Exception $e) {
            // Fallback method
            $sql = "SELECT id FROM donations ORDER BY id DESC LIMIT 1";
            $result = Database::query($sql);
            
            if (empty($result)) {
                return 'DON-00001';
            }
            
            $lastId = $result[0]['id'];
            $number = intval(substr($lastId, 4)) + 1;
            return 'DON-' . str_pad($number, 5, '0', STR_PAD_LEFT);
        }
    }
    
    /**
     * Generate next Subscription ID (Format: SUB-00001)
     * 
     * @return string Subscription ID
     */
    public static function generateSubscriptionId() {
        try {
            $conn = Database::getConnection();
            $stmt = $conn->query("SELECT get_next_subscription_id() as next_id");
            $result = $stmt->fetch();
            return $result['next_id'];
        } catch (Exception $e) {
            // Fallback method
            $sql = "SELECT id FROM subscriptions ORDER BY id DESC LIMIT 1";
            $result = Database::query($sql);
            
            if (empty($result)) {
                return 'SUB-00001';
            }
            
            $lastId = $result[0]['id'];
            $number = intval(substr($lastId, 4)) + 1;
            return 'SUB-' . str_pad($number, 5, '0', STR_PAD_LEFT);
        }
    }
    
    /**
     * Generate Partner ID for donors (Format: EIU-P-0001)
     * 
     * @return string Partner ID
     */
    public static function generatePartnerId() {
        try {
            $conn = Database::getConnection();
            $stmt = $conn->query("SELECT get_next_partner_id() as next_id");
            $result = $stmt->fetch();
            return $result['next_id'];
        } catch (Exception $e) {
            // Fallback method
            $sql = "SELECT partner_id FROM donations WHERE partner_id IS NOT NULL ORDER BY partner_id DESC LIMIT 1";
            $result = Database::query($sql);
            
            if (empty($result)) {
                return 'EIU-P-0001';
            }
            
            $lastId = $result[0]['partner_id'];
            $number = intval(substr($lastId, 6)) + 1;
            return 'EIU-P-' . str_pad($number, 4, '0', STR_PAD_LEFT);
        }
    }
    
    /**
     * Generate unique unsubscribe token
     * 
     * @param string $email Subscriber email
     * @return string Unique token
     */
    public static function generateUnsubscribeToken($email) {
        return hash('sha256', $email . time() . bin2hex(random_bytes(16)));
    }
    
    /**
     * Generate unique transaction reference
     * 
     * @return string Transaction reference
     */
    public static function generateTransactionRef() {
        return 'TXN' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 12));
    }
}
?>

