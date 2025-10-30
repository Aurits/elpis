-- ===================================================================
-- Elpis Initiative Uganda - Database Schema (Simplified Version)
-- ===================================================================
-- This version excludes views, functions, and triggers for compatibility
-- The PHP code has fallback logic for ID generation
-- ===================================================================

-- Create database
CREATE DATABASE IF NOT EXISTS u508604795_elpis
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE u508604795_elpis;

-- ===================================================================
-- TABLE: applications
-- ===================================================================
CREATE TABLE IF NOT EXISTS applications (
    id VARCHAR(20) PRIMARY KEY COMMENT 'Format: APP-0001',
    applicant_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    position VARCHAR(255) NOT NULL,
    department VARCHAR(100) NOT NULL,
    region VARCHAR(100) NOT NULL,
    cv_file_path VARCHAR(500),
    cover_letter TEXT,
    qualifications TEXT,
    date_submitted DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    reviewed_by VARCHAR(255),
    reviewed_at DATETIME,
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_status (status),
    INDEX idx_department (department),
    INDEX idx_region (region),
    INDEX idx_date_submitted (date_submitted),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- TABLE: donations
-- ===================================================================
CREATE TABLE IF NOT EXISTS donations (
    id VARCHAR(20) PRIMARY KEY COMMENT 'Format: DON-00001',
    donor_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    amount DECIMAL(15, 2) NOT NULL,
    payment_method ENUM('Mobile Money', 'Bank', 'Card') NOT NULL,
    transaction_id VARCHAR(100) UNIQUE,
    reference_code VARCHAR(100),
    partner_id VARCHAR(50) UNIQUE,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Success', 'Pending', 'Failed') DEFAULT 'Pending',
    confirmation_sent BOOLEAN DEFAULT FALSE,
    partner_email_sent BOOLEAN DEFAULT FALSE,
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_status (status),
    INDEX idx_payment_method (payment_method),
    INDEX idx_date (date),
    INDEX idx_email (email),
    INDEX idx_transaction_id (transaction_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- TABLE: subscriptions
-- ===================================================================
CREATE TABLE IF NOT EXISTS subscriptions (
    id VARCHAR(20) PRIMARY KEY COMMENT 'Format: SUB-00001',
    subscriber_name VARCHAR(255),
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    region VARCHAR(100),
    subscription_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    last_email_sent DATETIME,
    unsubscribe_token VARCHAR(100) UNIQUE,
    unsubscribed_at DATETIME,
    source VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_status (status),
    INDEX idx_email (email),
    INDEX idx_subscription_date (subscription_date),
    INDEX idx_unsubscribe_token (unsubscribe_token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- TABLE: admin_users
-- ===================================================================
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    role ENUM('admin', 'super_admin') DEFAULT 'admin',
    last_login DATETIME,
    is_active BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- TABLE: activity_logs
-- ===================================================================
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('application', 'donation', 'subscription', 'system') NOT NULL,
    message TEXT NOT NULL,
    status ENUM('pending', 'success', 'error') DEFAULT 'success',
    related_id VARCHAR(20),
    admin_email VARCHAR(255),
    ip_address VARCHAR(45),
    user_agent TEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_type (type),
    INDEX idx_status (status),
    INDEX idx_timestamp (timestamp),
    INDEX idx_admin_email (admin_email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- TABLE: newsletter_campaigns
-- ===================================================================
CREATE TABLE IF NOT EXISTS newsletter_campaigns (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(500) NOT NULL,
    content TEXT NOT NULL,
    recipients_count INT DEFAULT 0,
    sent_count INT DEFAULT 0,
    failed_count INT DEFAULT 0,
    sent_at DATETIME,
    created_by VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_sent_at (sent_at),
    INDEX idx_created_by (created_by)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- TABLE: email_queue
-- ===================================================================
CREATE TABLE IF NOT EXISTS email_queue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient_email VARCHAR(255) NOT NULL,
    recipient_name VARCHAR(255),
    subject VARCHAR(500) NOT NULL,
    body TEXT NOT NULL,
    email_type ENUM('application_confirmation', 'donation_thankyou', 'newsletter', 'status_update', 'other') NOT NULL,
    priority ENUM('low', 'normal', 'high') DEFAULT 'normal',
    status ENUM('pending', 'sent', 'failed') DEFAULT 'pending',
    attempts INT DEFAULT 0,
    last_attempt DATETIME,
    sent_at DATETIME,
    error_message TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_status (status),
    INDEX idx_priority (priority),
    INDEX idx_email_type (email_type),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- TABLE: file_uploads
-- ===================================================================
CREATE TABLE IF NOT EXISTS file_uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    original_filename VARCHAR(255) NOT NULL,
    stored_filename VARCHAR(255) NOT NULL UNIQUE,
    file_path VARCHAR(500) NOT NULL,
    file_size INT,
    mime_type VARCHAR(100),
    uploaded_by VARCHAR(255),
    related_type ENUM('application', 'donation', 'other'),
    related_id VARCHAR(20),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_related (related_type, related_id),
    INDEX idx_stored_filename (stored_filename)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- INSERT DEFAULT ADMIN USER
-- Password: admin123
-- ===================================================================
INSERT INTO admin_users (email, password_hash, full_name, role, is_active) VALUES
('admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'super_admin', TRUE);

-- ===================================================================
-- INSERT SAMPLE DATA
-- ===================================================================

-- Sample Applications
INSERT INTO applications (id, applicant_name, email, phone, position, department, region, cover_letter, qualifications, date_submitted, status) VALUES
('APP-0001', 'Sarah Nakato', 'sarah.nakato@email.com', '+256700123456', 'Program Officer', 'Education', 'Kampala', 'I am writing to express my strong interest in the Program Officer position.', 'Bachelor of Education, 3+ years NGO experience', '2024-10-15 09:30:00', 'pending'),
('APP-0002', 'John Okello', 'john.okello@email.com', '+256700234567', 'Field Coordinator', 'Healthcare', 'Gulu', 'My passion for community health makes me an ideal candidate.', 'Bachelor of Public Health, Community mobilization experience', '2024-10-18 14:15:00', 'approved'),
('APP-0003', 'Mary Nambi', 'mary.nambi@email.com', '+256700345678', 'Communications Specialist', 'Marketing', 'Wakiso', 'With my background in digital marketing, I am excited about this opportunity.', 'Bachelor of Mass Communication, Social media management', '2024-10-20 11:45:00', 'pending');

-- Sample Donations
INSERT INTO donations (id, donor_name, email, phone, amount, payment_method, transaction_id, reference_code, partner_id, date, status, confirmation_sent, partner_email_sent) VALUES
('DON-00001', 'James Ssemakula', 'james.ssemakula@email.com', '+256750111222', 50000.00, 'Mobile Money', 'MTN123456789', '10MILLIONHEARTS-James', 'EIU-P-0001', '2024-10-22 10:30:00', 'Success', TRUE, TRUE),
('DON-00002', 'Grace Atim', 'grace.atim@email.com', '+256750222333', 100000.00, 'Bank', 'STNB987654321', '10MILLIONHEARTS-Grace', 'EIU-P-0002', '2024-10-23 15:20:00', 'Success', TRUE, TRUE),
('DON-00003', 'Peter Mugisha', 'peter.mugisha@email.com', '+256750333444', 25000.00, 'Mobile Money', 'AIRT456789123', '10MILLIONHEARTS-Peter', 'EIU-P-0003', '2024-10-25 09:15:00', 'Pending', FALSE, FALSE);

-- Sample Subscriptions
INSERT INTO subscriptions (id, subscriber_name, email, phone, region, subscription_date, status, unsubscribe_token, source) VALUES
('SUB-00001', 'Rebecca Namusoke', 'rebecca.namusoke@email.com', '+256770111222', 'Kampala', '2024-10-10 12:00:00', 'Active', MD5(CONCAT('SUB-00001', RAND())), 'footer_form'),
('SUB-00002', 'David Kato', 'david.kato@email.com', '+256770222333', 'Jinja', '2024-10-12 14:30:00', 'Active', MD5(CONCAT('SUB-00002', RAND())), 'footer_form'),
('SUB-00003', 'Esther Auma', 'esther.auma@email.com', '+256770333444', 'Mbarara', '2024-10-15 16:45:00', 'Active', MD5(CONCAT('SUB-00003', RAND())), 'donate_page');

-- Sample Activity Logs
INSERT INTO activity_logs (type, message, status, related_id, timestamp) VALUES
('application', 'New application received from Sarah Nakato for Program Officer', 'pending', 'APP-0001', '2024-10-15 09:30:00'),
('application', 'Application approved for John Okello', 'success', 'APP-0002', '2024-10-18 16:00:00'),
('donation', 'Donation of UGX 50,000 received from James Ssemakula', 'success', 'DON-00001', '2024-10-22 10:30:00'),
('subscription', 'New newsletter subscription from Rebecca Namusoke', 'success', 'SUB-00001', '2024-10-10 12:00:00');

-- ===================================================================
-- END OF SCHEMA
-- ===================================================================

