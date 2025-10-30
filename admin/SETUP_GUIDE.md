# Elpis Initiative Uganda - Database Integration Setup Guide

## 📋 Table of Contents
1. [Prerequisites](#prerequisites)
2. [Database Setup](#database-setup)
3. [Configuration](#configuration)
4. [Testing](#testing)
5. [Integration Status](#integration-status)
6. [Troubleshooting](#troubleshooting)

---

## Prerequisites

Before you begin, ensure you have:

- ✅ **PHP 7.4 or higher** (with PDO MySQL extension)
- ✅ **MySQL 5.7 or higher** (or MariaDB 10.2+)
- ✅ **Apache/Nginx** web server
- ✅ **phpMyAdmin** (optional, for easier database management)
- ✅ **Composer** (optional, for future dependencies)

---

## Database Setup

### Step 1: Import Database Schema

**Option A: Using phpMyAdmin**
1. Open phpMyAdmin in your browser (usually `http://localhost/phpmyadmin`)
2. Click on "New" in the left sidebar
3. Click "Import" tab at the top
4. Click "Choose File" and select `admin/database/elpis_db.sql`
5. Scroll down and click "Go"
6. Wait for success message

**Option B: Using MySQL Command Line**
```bash
# Navigate to your project directory
cd C:\Users\HP\Documents\PROJECTS\ELPIS

# Import the database
mysql -u root -p < admin/database/elpis_db.sql
```

**Option C: Using XAMPP/WAMP**
1. Open your control panel
2. Start MySQL
3. Open MySQL console
4. Run: `source C:/Users/HP/Documents/PROJECTS/ELPIS/admin/database/elpis_db.sql`

### Step 2: Verify Database Creation

After import, verify the database was created:

```sql
USE elpis_db;
SHOW TABLES;
```

You should see 8 tables:
- `admin_users`
- `applications`
- `donations`
- `subscriptions`
- `activity_logs`
- `newsletter_campaigns`
- `email_queue`
- `file_uploads`

---

## Configuration

### Step 1: Update Database Credentials

Open `admin/config/database.php` and update the following lines:

```php
define('DB_HOST', 'localhost');      // Usually 'localhost'
define('DB_NAME', 'elpis_db');       // Database name
define('DB_USER', 'root');           // Your MySQL username
define('DB_PASS', '');               // Your MySQL password
```

**Common Configurations:**

**XAMPP (Windows):**
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Usually empty
```

**WAMP (Windows):**
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Usually empty
```

**MAMP (Mac):**
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
```

**Live Server:**
```php
define('DB_HOST', 'localhost');  // Or your host's MySQL server
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### Step 2: Set File Permissions (Linux/Mac)

If you're on Linux or Mac, set proper permissions:

```bash
chmod 755 admin/config
chmod 644 admin/config/database.php
chmod 755 admin/handlers
chmod 755 admin/api
chmod 777 uploads  # Will be created automatically
```

### Step 3: Create Uploads Directory

The system will auto-create this, but you can do it manually:

```bash
mkdir -p uploads/cvs
chmod 777 uploads/cvs
```

---

## Testing

### Step 1: Test Database Connection

Visit: `http://localhost:3000/admin/test-connection.php`

You should see:
- ✅ Database connection successful
- ✅ All 8 tables found
- ✅ Sample data loaded

### Step 2: Test Admin Login

1. Visit: `http://localhost:3000/admin/`
2. Use default credentials:
   - **Email:** `admin@example.com`
   - **Password:** `admin123`
3. You should be redirected to the dashboard

### Step 3: Test Dashboard

After login, verify:
- ✅ Dashboard shows statistics (3 applications, 3 donations, 3 subscriptions)
- ✅ Recent activity feed displays
- ✅ Charts are rendering with data

### Step 4: Test Management Pages

1. Click "Management" in sidebar
2. Check each tab:
   - **Applications:** Should show 3 sample applications
   - **Donations:** Should show 3 sample donations
   - **Subscriptions:** Should show 3 sample subscriptions

---

## Integration Status

### ✅ Completed Components

**Backend Infrastructure:**
- ✅ Database schema with 8 tables
- ✅ PDO connection class with error handling
- ✅ ID generation utilities (APP-XXXX, DON-XXXXX, SUB-XXXXX)
- ✅ Validation utilities (email, phone, files)
- ✅ File upload handler (CV uploads)

**API Endpoints:**
- ✅ `admin/api/auth.php` - Login/logout
- ✅ `admin/api/applications.php` - CRUD for applications
- ✅ `admin/api/donations.php` - CRUD for donations
- ✅ `admin/api/subscriptions.php` - CRUD for subscriptions
- ✅ `admin/api/dashboard-stats.php` - Real-time statistics

**Form Handlers:**
- ✅ `admin/handlers/application-submit.php` - Process applications from `apply.html`
- ✅ `admin/handlers/donation-confirm.php` - Process donation confirmations
- ✅ `admin/handlers/newsletter-signup.php` - Process newsletter signups

**Admin Panel:**
- ✅ Database-backed authentication
- ✅ Session management
- ✅ Activity logging

### 🔄 Pending Integration

**Frontend Forms (Needs JavaScript Update):**
- ⏳ Connect `apply.html` form to `admin/handlers/application-submit.php`
- ⏳ Create donation confirmation page
- ⏳ Connect newsletter forms to `admin/handlers/newsletter-signup.php`

**Admin Panel JavaScript (Needs Update):**
- ⏳ Replace sample data with API calls in `admin/script.js`
- ⏳ Connect dashboard to `admin/api/dashboard-stats.php`
- ⏳ Connect management tables to respective APIs

**Email System (Optional):**
- ⏳ Install PHPMailer
- ⏳ Create email templates
- ⏳ Implement email sending functions

---

## Troubleshooting

### Issue: "Database connection failed"

**Solution:**
1. Check MySQL is running
2. Verify credentials in `admin/config/database.php`
3. Test connection: `mysql -u root -p` in terminal
4. Check PHP PDO extension: `php -m | grep pdo`

### Issue: "Table doesn't exist"

**Solution:**
1. Re-import `admin/database/elpis_db.sql`
2. Verify database name matches config
3. Check: `SHOW DATABASES;` in MySQL

### Issue: "Permission denied" on file upload

**Solution:**
```bash
chmod 777 uploads/cvs
chown www-data:www-data uploads  # Linux
```

### Issue: "Function get_next_application_id does not exist"

**Solution:**
The SQL file includes functions, but some MySQL setups may not support them. The code has fallback logic, so this shouldn't cause issues.

### Issue: Login fails with correct credentials

**Solution:**
1. Check `admin_users` table exists
2. Verify password hash in database
3. Check PHP session is working: `<?php session_start(); echo session_id(); ?>`

---

## Next Steps

### 1. Change Default Admin Password

```sql
UPDATE admin_users 
SET password_hash = '$2y$10$YOUR_NEW_HASH_HERE'
WHERE email = 'admin@example.com';
```

Or use the "Change Password" feature in admin panel (when implemented).

### 2. Connect Frontend Forms

Update JavaScript in:
- `script.js` - Add AJAX submission for apply.html
- Create donation confirmation page
- Connect newsletter forms

### 3. Update Admin Panel JavaScript

Replace sample data with API calls in `admin/script.js`:
- Dashboard stats → `admin/api/dashboard-stats.php`
- Applications → `admin/api/applications.php`
- Donations → `admin/api/donations.php`
- Subscriptions → `admin/api/subscriptions.php`

### 4. Implement Email System (Optional)

```bash
composer require phpmailer/phpmailer
```

Then implement email templates and sending logic.

---

## Support

If you encounter any issues:

1. Check PHP error logs: `tail -f /var/log/apache2/error.log`
2. Check MySQL error logs
3. Enable error reporting in PHP:
   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```

---

**Created:** 2025-10-30
**Version:** 1.0
**Status:** Ready for Integration

