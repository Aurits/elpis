# 🚀 Quick Reference Card

## One-Minute Setup

```bash
# 1. Import database
mysql -u root -p < admin/database/elpis_db.sql

# 2. Update config (if needed)
# Edit: admin/config/database.php

# 3. Test connection
# Visit: http://localhost:3000/admin/test-connection.php

# 4. Login
# Visit: http://localhost:3000/admin/
# Email: admin@example.com
# Password: admin123
```

---

## 📂 File Locations

| Purpose | File Path |
|---------|-----------|
| Database Schema | `admin/database/elpis_db.sql` |
| DB Configuration | `admin/config/database.php` |
| Test Connection | `admin/test-connection.php` |
| Login Page | `admin/index.php` |
| Dashboard | `admin/dashboard.php` |
| Management | `admin/management.php` |

---

## 🔗 API Endpoints Quick Reference

### Authentication
```
POST   /admin/api/auth.php?action=login
POST   /admin/api/auth.php?action=logout
GET    /admin/api/auth.php?action=check
```

### Applications
```
GET    /admin/api/applications.php?action=list&page=1
GET    /admin/api/applications.php?action=view&id=APP-0001
POST   /admin/api/applications.php?action=update_status
GET    /admin/api/applications.php?action=export
```

### Donations
```
GET    /admin/api/donations.php?action=list&page=1
POST   /admin/api/donations.php?action=update_status
GET    /admin/api/donations.php?action=export
```

### Subscriptions
```
GET    /admin/api/subscriptions.php?action=list&page=1
POST   /admin/api/subscriptions.php?action=send_newsletter
GET    /admin/api/subscriptions.php?action=export
```

### Dashboard Stats
```
GET    /admin/api/dashboard-stats.php?action=overview
GET    /admin/api/dashboard-stats.php?action=activity
GET    /admin/api/dashboard-stats.php?action=donations_chart
```

---

## 📨 Form Handlers (Public)

```
POST   /admin/handlers/application-submit.php
POST   /admin/handlers/donation-confirm.php
POST   /admin/handlers/newsletter-signup.php
```

---

## 🗄️ Database Tables

```sql
admin_users          -- Admin authentication
applications         -- Job applications
donations            -- Donation tracking
subscriptions        -- Newsletter subscribers
activity_logs        -- System audit trail
newsletter_campaigns -- Email campaigns
email_queue          -- Email processing queue
file_uploads         -- Uploaded files tracking
```

---

## 🔐 Default Credentials

```
Email:    admin@example.com
Password: admin123
```

**⚠️ IMPORTANT:** Change this password after first login!

---

## 🧪 Testing Commands

### Test Database Connection
```bash
mysql -u root -p -e "USE elpis_db; SHOW TABLES;"
```

### Check Admin User
```bash
mysql -u root -p -e "USE elpis_db; SELECT * FROM admin_users;"
```

### Count Records
```bash
mysql -u root -p -e "USE elpis_db; 
SELECT 
    (SELECT COUNT(*) FROM applications) as apps,
    (SELECT COUNT(*) FROM donations) as donations,
    (SELECT COUNT(*) FROM subscriptions) as subs;"
```

---

## 🎨 ID Formats

| Type | Format | Example |
|------|--------|---------|
| Application | APP-XXXX | APP-0001 |
| Donation | DON-XXXXX | DON-00001 |
| Subscription | SUB-XXXXX | SUB-00001 |
| Partner | EIU-P-XXXX | EIU-P-0001 |

---

## 📱 Sample API Calls

### Get Applications (JavaScript)
```javascript
const response = await fetch('admin/api/applications.php?action=list&page=1&per_page=10');
const data = await response.json();
console.log(data.data); // Array of applications
```

### Submit Application (JavaScript)
```javascript
const formData = new FormData();
formData.append('name', 'John Doe');
formData.append('email', 'john@email.com');
formData.append('cv', fileInput.files[0]);
// ... other fields

const response = await fetch('admin/handlers/application-submit.php', {
    method: 'POST',
    body: formData
});
const result = await response.json();
```

### Get Dashboard Stats (JavaScript)
```javascript
const response = await fetch('admin/api/dashboard-stats.php?action=overview');
const stats = await response.json();
console.log(stats.data);
// { total_applications: 3, total_donations: 150000, ... }
```

---

## 🛠️ Common Tasks

### Change Admin Password (SQL)
```sql
-- Generate new hash in PHP first
-- $hash = password_hash('new_password', PASSWORD_DEFAULT);

UPDATE admin_users 
SET password_hash = '$2y$10$...' 
WHERE email = 'admin@example.com';
```

### Clear Sample Data
```sql
TRUNCATE TABLE applications;
TRUNCATE TABLE donations;
TRUNCATE TABLE subscriptions;
TRUNCATE TABLE activity_logs;
-- Admin user remains
```

### Add New Admin User
```php
<?php
require_once 'admin/config/database.php';

$email = 'newemail@example.com';
$password = 'secure_password';
$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO admin_users (email, password_hash, full_name, role) 
        VALUES (?, ?, ?, 'admin')";
Database::execute($sql, [$email, $hash, 'Admin Name']);
?>
```

---

## 🐛 Troubleshooting

| Problem | Solution |
|---------|----------|
| Can't connect to DB | Check `admin/config/database.php` credentials |
| Tables not found | Re-import `admin/database/elpis_db.sql` |
| Login fails | Verify admin_users table has default user |
| File upload fails | Check `uploads/` directory permissions (777) |
| PHP errors | Enable: `ini_set('display_errors', 1);` |

---

## 📞 Support Files

- **Full Guide:** `admin/SETUP_GUIDE.md`
- **Complete Summary:** `admin/INTEGRATION_SUMMARY.md`
- **This Card:** `admin/QUICK_REFERENCE.md`

---

**Pro Tip:** Bookmark `admin/test-connection.php` for quick health checks!

