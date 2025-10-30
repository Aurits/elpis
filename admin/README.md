# Elpis Initiative Uganda - Admin Dashboard (PHP)

A complete PHP conversion of the Next.js admin dashboard with all features intact.

## 📁 File Structure

```
admin/
├── dashboard.php           # Main dashboard page with metrics, charts, and activity feed
├── management.php          # Management page with 3 tabs (Applications, Donations, Subscriptions)
├── header.php             # Header component with breadcrumbs and user menu
├── sidebar.php            # Sidebar navigation with mobile toggle
├── sample-data.php        # PHP data generation (50 applications, 100 donations, 200 subscriptions)
├── styles.css             # Complete CSS converted from Tailwind
├── script.js              # All JavaScript functionality (filtering, sorting, charts, modals)
└── README.md              # This file
```

## 🎨 Design Features

### Color Palette
- **Background**: `#0F0F0F` (deep black)
- **Card**: `#1A1A1A` (dark gray)
- **Border**: `#2A2A2A` (subtle gray)
- **Accent Pink**: `#EC008C` (brand color)
- **Accent Blue**: `#00AEEF` (brand color)
- **Success**: `#10B981`
- **Warning**: `#F59E0B`
- **Error**: `#EF4444`

### UI Components
- Glassmorphism cards with backdrop blur
- Custom dark scrollbar
- Responsive sidebar (collapsible on mobile)
- Toast notifications
- Modal dialogs
- Status badges (pending, approved, rejected)
- Data tables with pagination
- Interactive charts (Chart.js)
- Search and filter functionality

## 📊 Dashboard Page (`dashboard.php`)

### Metrics Cards
1. Total Applications (with 12% trend)
2. Pending Applications (highlighted in warning yellow)
3. Total Donations (in UGX millions with 8% trend)
4. Active Subscriptions (with 5% trend)

### Charts
1. **Donations Over Time** - Line chart showing 6 months of donation data
2. **Applications by Department** - Bar chart with 6 departments
3. **Donation Distribution by Region** - Pie chart showing regional breakdown

### Activity Feed
- Last 10 activities with timestamps
- Icons for different activity types (application, donation, subscription)
- Status indicators (success, error, pending)

## 📋 Management Page (`management.php`)

### Applications Tab
**Features:**
- Search by name, email, or position
- Filter by status (Pending, Approved, Rejected)
- Filter by department (6 departments)
- Filter by region (8 regions)
- Expandable row details showing:
  - Full application information
  - Cover letter
  - Qualifications
  - CV download link
- Quick approve/reject buttons
- View details modal
- Export to CSV
- Pagination (10 items per page)

**Data:** 50 applications with realistic Ugandan names

### Donations Tab
**Features:**
- Summary cards:
  - Total Donations (This Month)
  - Average Donation Amount
  - Most Popular Payment Method
- Search by donor name, email, or transaction ID
- Filter by payment method (Mobile Money, Bank, Card)
- Filter by status (Success, Pending, Failed)
- Actions:
  - View Receipt
  - Send Thank You Email
- Export to Excel
- Pagination (10 items per page)

**Data:** 100 donations ranging from 10,000 to 500,000 UGX

### Subscriptions Tab
**Features:**
- Search by name, email, or phone
- Filter by status (Active, Inactive)
- Filter by region (8 regions)
- Bulk selection with checkboxes
- Toggle Active/Inactive status with switch
- Bulk actions:
  - Send Newsletter to Selected
  - Export Selected
- Individual actions:
  - View History
  - Send Newsletter
- Pagination (10 items per page)

**Data:** 200 subscriptions with Ugandan phone numbers

## 🚀 Installation & Setup

### Requirements
- PHP 7.4 or higher
- Web server (Apache, Nginx, or PHP built-in server)
- Modern browser with JavaScript enabled

### Quick Start

1. **Place files in your web directory:**
   ```bash
   # Copy the admin folder to your web server
   cp -r admin /var/www/html/admin
   # OR use PHP built-in server
   cd admin
   php -S localhost:8000
   ```

2. **Access the dashboard:**
   ```
   http://localhost:8000/dashboard.php
   ```

3. **Navigate between pages:**
   - Dashboard: `dashboard.php`
   - Applications: `management.php?tab=applications`
   - Donations: `management.php?tab=donations`
   - Subscriptions: `management.php?tab=subscriptions`

## 🎯 Key Features

### Responsive Design
- ✅ Mobile-first approach
- ✅ Collapsible sidebar on mobile
- ✅ Responsive tables with horizontal scroll
- ✅ Adaptive charts
- ✅ Touch-friendly buttons and controls

### Interactive Elements
- ✅ Real-time search and filtering
- ✅ Client-side pagination
- ✅ Modal dialogs for detailed views
- ✅ Toast notifications for user feedback
- ✅ Expandable table rows
- ✅ Bulk selection and actions
- ✅ Toggle switches for status changes

### Data Visualization
- ✅ Chart.js integration for beautiful charts
- ✅ Line chart with gradient fill
- ✅ Bar chart with rounded corners
- ✅ Pie chart with legend
- ✅ Responsive chart containers
- ✅ Custom tooltips with dark theme

### Data Management
- ✅ Search functionality across all tabs
- ✅ Multiple filter options
- ✅ Export capabilities (CSV/Excel placeholders)
- ✅ Pagination with page info
- ✅ Status badges with color coding
- ✅ Action buttons for each record

## 🔧 Customization

### Modify Sample Data
Edit `sample-data.php` to change:
- Number of records generated
- Date ranges
- Default values
- Add/remove departments or regions

### Change Colors
Edit CSS variables in `styles.css`:
```css
:root {
    --color-accent-pink: #EC008C;
    --color-accent-blue: #00AEEF;
    /* ... other colors */
}
```

### Add New Features
1. Add new table columns in `management.php`
2. Update filtering logic in `script.js`
3. Add corresponding styles in `styles.css`

## 📱 Browser Support

- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## 🔐 Security Notes

**Important:** This is a frontend-only implementation. For production use:

1. Add authentication/authorization
2. Implement CSRF protection
3. Sanitize all user inputs
4. Use prepared statements for database queries
5. Add session management
6. Implement role-based access control
7. Add SSL/TLS encryption
8. Validate all data server-side

## 📊 Chart.js Integration

The dashboard uses Chart.js 4.4.0 (loaded via CDN):
```html
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
```

To customize charts, edit the `initializeDashboardCharts()` function in `script.js`.

## 🎨 Font Integration

The dashboard uses Inter font family (loaded via Google Fonts):
```html
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
```

## 📝 Code Structure

### PHP Components
- **header.php**: Reusable header with dynamic title and breadcrumbs
- **sidebar.php**: Navigation menu with active state detection
- **sample-data.php**: Data generation with arrays exported for use in pages

### JavaScript Organization
- Global state management (pagination, filters, selections)
- Event listeners and initialization
- Tab switching functionality
- Table rendering and filtering
- Modal and toast functions
- Chart initialization
- Utility functions (formatting, escaping)

### CSS Architecture
- CSS variables for theming
- Utility classes for common patterns
- Component-specific styles
- Responsive media queries
- Dark theme optimized

## 🚀 Performance

- Minimal dependencies (only Chart.js)
- Client-side filtering for instant results
- Optimized CSS with no redundant rules
- Efficient DOM manipulation
- Lazy loading of chart data

## 📄 License

This admin dashboard is part of the Elpis Initiative Uganda project.

---

**Version:** 1.0.0  
**Last Updated:** October 30, 2025  
**Converted From:** Next.js 14+ Admin Dashboard  
**Technology Stack:** PHP 7.4+, Vanilla JavaScript, CSS3, Chart.js 4.4.0

