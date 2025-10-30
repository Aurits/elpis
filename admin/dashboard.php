<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Elpis Initiative Uganda Admin</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    // Include sample data
    require_once 'sample-data.php';
    
    // Calculate metrics
    $totalApplications = count($applications);
    $pendingApplications = count(array_filter($applications, function($app) {
        return $app['status'] === 'pending';
    }));
    $totalDonations = array_sum(array_column($donations, 'amount'));
    $activeSubscriptions = count(array_filter($subscriptions, function($sub) {
        return $sub['status'] === 'Active';
    }));
    
    // Set page variables for header
    $page_title = 'Dashboard';
    $breadcrumbs = [['label' => 'Home']];
    ?>

    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <?php include 'header.php'; ?>
            
            <main class="main">
                <div class="content-wrapper">
                    <!-- Metrics Grid -->
                    <div class="metrics-grid">
                        <!-- Total Applications -->
                        <div class="card glass-card">
                            <div class="card-content">
                                <div class="metric-card">
                                    <div class="metric-info">
                                        <p class="metric-title">Total Applications</p>
                                        <p class="metric-value"><?php echo $totalApplications; ?></p>
                                        <div class="metric-trend positive">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                <polyline points="17 6 23 6 23 12"></polyline>
                                            </svg>
                                            <span>12%</span>
                                            <span class="metric-trend-label">vs last month</span>
                                        </div>
                                    </div>
                                    <div class="metric-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Applications -->
                        <div class="card glass-card metric-card warning">
                            <div class="card-content">
                                <div class="metric-card">
                                    <div class="metric-info">
                                        <p class="metric-title">Pending Applications</p>
                                        <p class="metric-value"><?php echo $pendingApplications; ?></p>
                                    </div>
                                    <div class="metric-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Donations -->
                        <div class="card glass-card">
                            <div class="card-content">
                                <div class="metric-card">
                                    <div class="metric-info">
                                        <p class="metric-title">Total Donations</p>
                                        <p class="metric-value">UGX <?php echo number_format($totalDonations / 1000000, 1); ?>M</p>
                                        <div class="metric-trend positive">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                <polyline points="17 6 23 6 23 12"></polyline>
                                            </svg>
                                            <span>8%</span>
                                            <span class="metric-trend-label">vs last month</span>
                                        </div>
                                    </div>
                                    <div class="metric-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="1" x2="12" y2="23"></line>
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Subscriptions -->
                        <div class="card glass-card">
                            <div class="card-content">
                                <div class="metric-card">
                                    <div class="metric-info">
                                        <p class="metric-title">Active Subscriptions</p>
                                        <p class="metric-value"><?php echo $activeSubscriptions; ?></p>
                                        <div class="metric-trend positive">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                <polyline points="17 6 23 6 23 12"></polyline>
                                            </svg>
                                            <span>5%</span>
                                            <span class="metric-trend-label">vs last month</span>
                                        </div>
                                    </div>
                                    <div class="metric-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="charts-grid">
                        <!-- Donations Chart -->
                        <div class="card glass-card">
                            <div class="card-header">
                                <h3 class="card-title">Donations Over Time</h3>
                            </div>
                            <div class="card-content">
                                <div class="chart-container">
                                    <canvas id="donationsChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Applications Chart -->
                        <div class="card glass-card">
                            <div class="card-header">
                                <h3 class="card-title">Applications by Department</h3>
                            </div>
                            <div class="card-content">
                                <div class="chart-container">
                                    <canvas id="applicationsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="charts-grid three-col">
                        <!-- Donations Distribution Chart -->
                        <div class="card glass-card">
                            <div class="card-header">
                                <h3 class="card-title">Donation Distribution by Region</h3>
                            </div>
                            <div class="card-content">
                                <div class="chart-container">
                                    <canvas id="distributionChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Feed -->
                        <div class="card glass-card">
                            <div class="card-header">
                                <h3 class="card-title">Recent Activity</h3>
                            </div>
                            <div class="card-content">
                                <div class="activity-feed">
                                    <?php foreach ($activities as $activity): ?>
                                        <div class="activity-item">
                                            <div class="activity-icon">
                                                <?php if ($activity['type'] === 'application'): ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                        <polyline points="14 2 14 8 20 8"></polyline>
                                                    </svg>
                                                <?php elseif ($activity['type'] === 'donation'): ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                                    </svg>
                                                <?php else: ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                        <polyline points="22,6 12,13 2,6"></polyline>
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                            <div class="activity-content">
                                                <p class="activity-message"><?php echo htmlspecialchars($activity['message']); ?></p>
                                                <p class="activity-timestamp"><?php echo formatTimestamp($activity['timestamp']); ?></p>
                                            </div>
                                            <div class="activity-status <?php echo $activity['status']; ?>">
                                                <?php if ($activity['status'] === 'success'): ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                    </svg>
                                                <?php elseif ($activity['status'] === 'error'): ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                                    </svg>
                                                <?php elseif ($activity['status'] === 'pending'): ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <polyline points="12 6 12 12 16 14"></polyline>
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <a href="management.php?tab=applications" class="btn btn-primary">Review Applications</a>
                        <a href="management.php?tab=donations" class="btn btn-outline">View Donations</a>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Main Script -->
    <script src="script.js"></script>
    
    <!-- Dashboard Charts Script -->
    <script>
        // Chart data from PHP
        const donationsChartData = <?php echo json_encode($donationsChartData); ?>;
        const applicationsChartData = <?php echo json_encode($applicationsChartData); ?>;
        const donationsDistributionData = <?php echo json_encode($donationsDistributionData); ?>;
        
        // Initialize charts when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initializeDashboardCharts();
        });
    </script>
</body>
</html>

