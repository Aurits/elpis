<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management - Elpis Initiative Uganda Admin</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    // Get active tab from URL parameter
    $activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'applications';
    
    // Set page variables for header
    $page_title = 'Management';
    $breadcrumbs = [['label' => 'Home'], ['label' => 'Management']];
    ?>

    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <?php include 'header.php'; ?>
            
            <main class="main">
                <div class="content-wrapper">
                    <!-- Tabs -->
                    <div class="tabs-container">
                        <div class="tabs-list">
                            <button class="tab-trigger <?php echo $activeTab === 'applications' ? 'active' : ''; ?>" 
                                    onclick="switchTab('applications')">
                                Applications
                            </button>
                            <button class="tab-trigger <?php echo $activeTab === 'donations' ? 'active' : ''; ?>" 
                                    onclick="switchTab('donations')">
                                Donations
                            </button>
                            <button class="tab-trigger <?php echo $activeTab === 'subscriptions' ? 'active' : ''; ?>" 
                                    onclick="switchTab('subscriptions')">
                                Subscriptions
                            </button>
                        </div>

                        <!-- Applications Tab Content -->
                        <div class="tab-content <?php echo $activeTab === 'applications' ? 'active' : ''; ?>" id="applications-tab">
                            <!-- Filters -->
                            <div class="table-filters">
                                <div class="filter-row">
                                    <div class="search-input-wrapper">
                                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.35-4.35"></path>
                                        </svg>
                                        <input type="text" class="input" id="app-search" placeholder="Search by name, email, or position...">
                                    </div>
                                    <select class="select" id="app-status-filter">
                                        <option value="all">All Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                    <select class="select" id="app-department-filter">
                                        <option value="all">All Departments</option>
                                    </select>
                                    <select class="select" id="app-region-filter">
                                        <option value="all">All Regions</option>
                                    </select>
                                </div>
                                <div class="filter-info">
                                    <p class="filter-info-text" id="app-filter-info">
                                        Showing <span id="app-showing-count">0</span> applications
                                    </p>
                                    <div class="filter-actions">
                                        <button class="btn btn-outline btn-sm" onclick="exportApplicationsToCSV()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                            </svg>
                                            Export CSV
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Applications Table -->
                            <div class="card table-card">
                                <div class="card-content no-padding">
                                    <div class="table-wrapper">
                                        <table class="table" id="applications-table">
                                            <thead>
                                                <tr>
                                                    <th>Applicant Name</th>
                                                    <th>Email</th>
                                                    <th>Position</th>
                                                    <th>Department</th>
                                                    <th>Region</th>
                                                    <th>Date Submitted</th>
                                                    <th>Status</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="applications-tbody">
                                                <!-- Populated by JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination">
                                <button class="btn btn-outline" id="app-prev-btn" onclick="changeApplicationsPage(-1)">Previous</button>
                                <span class="pagination-info" id="app-pagination-info">Page 1 of 1</span>
                                <button class="btn btn-outline" id="app-next-btn" onclick="changeApplicationsPage(1)">Next</button>
                            </div>
                        </div>

                        <!-- Donations Tab Content -->
                        <div class="tab-content <?php echo $activeTab === 'donations' ? 'active' : ''; ?>" id="donations-tab">
                            <!-- Period Selector -->
                            <div class="table-filters" style="margin-bottom: 1rem;">
                                <div class="filter-row" style="justify-content: flex-end;">
                                    <label for="don-period" class="sr-only">Period</label>
                                    <select class="select" id="don-period" style="max-width: 180px;">
                                        <option value="year">This Year</option>
                                        <option value="all">All Time</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Summary Cards -->
                            <div class="summary-cards">
                                <div class="summary-card">
                                    <p class="summary-label">Total Donations (<span id="don-period-label">This Year</span>)</p>
                                    <p class="summary-value" id="don-total-month">—</p>
                                </div>
                                <div class="summary-card">
                                    <p class="summary-label">Average Donation (<span id="don-period-label-avg">This Year</span>)</p>
                                    <p class="summary-value" id="don-average">—</p>
                                </div>
                                <div class="summary-card">
                                    <p class="summary-label">Most Popular Method (<span id="don-period-label-pop">This Year</span>)</p>
                                    <p class="summary-value" id="don-popular-method">—</p>
                                </div>
                            </div>

                            <!-- Filters -->
                            <div class="table-filters">
                                <div class="filter-row">
                                    <div class="search-input-wrapper">
                                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.35-4.35"></path>
                                        </svg>
                                        <input type="text" class="input" id="don-search" placeholder="Search by donor, email, or transaction ID...">
                                    </div>
                                    <select class="select" id="don-payment-filter">
                                        <option value="all">All Payment Methods</option>
                                        <option value="Mobile Money">Mobile Money</option>
                                        <option value="Bank">Bank</option>
                                        <option value="Card">Card</option>
                                    </select>
                                    <select class="select" id="don-status-filter">
                                        <option value="all">All Status</option>
                                        <option value="Success">Success</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Failed">Failed</option>
                                    </select>
                                </div>
                                <div class="filter-info">
                                    <p class="filter-info-text" id="don-filter-info">
                                        Showing <span id="don-showing-count">0</span> donations
                                    </p>
                                    <div class="filter-actions">
                                        <button class="btn btn-outline btn-sm" onclick="exportDonationsToExcel()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                            </svg>
                                            Export Excel
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Donations Table -->
                            <div class="card table-card">
                                <div class="card-content no-padding">
                                    <div class="table-wrapper">
                                        <table class="table" id="donations-table">
                                            <thead>
                                                <tr>
                                                    <th>Donor Name</th>
                                                    <th>Email</th>
                                                    <th>Amount</th>
                                                    <th>Payment Method</th>
                                                    <th>Transaction ID</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="donations-tbody">
                                                <!-- Populated by JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination">
                                <button class="btn btn-outline" id="don-prev-btn" onclick="changeDonationsPage(-1)">Previous</button>
                                <span class="pagination-info" id="don-pagination-info">Page 1 of 1</span>
                                <button class="btn btn-outline" id="don-next-btn" onclick="changeDonationsPage(1)">Next</button>
                            </div>
                        </div>

                        <!-- Subscriptions Tab Content -->
                        <div class="tab-content <?php echo $activeTab === 'subscriptions' ? 'active' : ''; ?>" id="subscriptions-tab">
                            <!-- Filters -->
                            <div class="table-filters">
                                <div class="filter-row">
                                    <div class="search-input-wrapper">
                                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.35-4.35"></path>
                                        </svg>
                                        <input type="text" class="input" id="sub-search" placeholder="Search by name, email, or phone...">
                                    </div>
                                    <select class="select" id="sub-status-filter">
                                        <option value="all">All Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    <select class="select" id="sub-region-filter">
                                        <option value="all">All Regions</option>
                                    </select>
                                </div>
                                <div class="filter-info">
                                    <p class="filter-info-text" id="sub-filter-info">
                                        Showing <span id="sub-showing-count">0</span> subscriptions
                                        <span id="sub-selected-info" class="hidden"></span>
                                    </p>
                                    <div class="filter-actions" id="sub-bulk-actions" style="display: none;">
                                        <button class="btn btn-outline btn-sm" onclick="sendNewsletterToSelected()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                <polyline points="22,6 12,13 2,6"></polyline>
                                            </svg>
                                            Send to Selected
                                        </button>
                                        <button class="btn btn-outline btn-sm" onclick="exportSelectedSubscriptions()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                            </svg>
                                            Export Selected
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Subscriptions Table -->
                            <div class="card table-card">
                                <div class="card-content no-padding">
                                    <div class="table-wrapper">
                                        <table class="table" id="subscriptions-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">
                                                        <input type="checkbox" class="checkbox" id="sub-select-all" onchange="toggleSelectAllSubscriptions()">
                                                    </th>
                                                    <th>Subscriber Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Region</th>
                                                    <th>Subscription Date</th>
                                                    <th>Status</th>
                                                    <th>Last Email Sent</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="subscriptions-tbody">
                                                <!-- Populated by JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination">
                                <button class="btn btn-outline" id="sub-prev-btn" onclick="changeSubscriptionsPage(-1)">Previous</button>
                                <span class="pagination-info" id="sub-pagination-info">Page 1 of 1</span>
                                <button class="btn btn-outline" id="sub-next-btn" onclick="changeSubscriptionsPage(1)">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Application Details Modal -->
    <div class="modal-overlay" id="applicationModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title" id="modalAppName">Application Details</h3>
                <p class="modal-description" id="modalAppPosition"></p>
            </div>
            <div class="modal-content" id="modalAppContent">
                <!-- Populated by JavaScript -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('applicationModal')">Close</button>
                <button class="btn btn-outline" style="background-color: var(--color-error);" onclick="handleApplicationAction('reject')">Reject</button>
                <button class="btn btn-primary" onclick="handleApplicationAction('approve')">Approve</button>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal-overlay" id="confirmModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title" id="confirmModalTitle">Confirm Action</h3>
                <p class="modal-description" id="confirmModalDescription"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('confirmModal')">Cancel</button>
                <button class="btn btn-primary" id="confirmModalBtn">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Main Script -->
    <script src="script.js"></script>
</body>
</html>

