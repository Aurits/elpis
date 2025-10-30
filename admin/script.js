// Elpis Initiative Uganda - Admin Dashboard JavaScript
// Main functionality for all interactive features

// ===== Global State =====
let currentAppPage = 1;
let currentDonPage = 1;
let currentSubPage = 1;
const itemsPerPage = 10;
let selectedSubscriptions = new Set();
let currentApplication = null;

// ===== Initialize on DOM Load =====
document.addEventListener('DOMContentLoaded', function() {
    initializeTheme();
    initializeSidebar();
    initializeHeader();
    
    // Initialize management page features if data exists
    if (typeof applicationsData !== 'undefined') {
        initializeApplicationsTab();
    }
    if (typeof donationsData !== 'undefined') {
        initializeDonationsTab();
    }
    if (typeof subscriptionsData !== 'undefined') {
        initializeSubscriptionsTab();
    }
});

// ===== Theme Functions =====
function initializeTheme() {
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const sunIcon = document.getElementById('sunIcon');
    const moonIcon = document.getElementById('moonIcon');
    
    // Check for saved theme preference or default to light
    const savedTheme = localStorage.getItem('theme') || 'light';
    
    // Apply saved theme
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-theme');
        if (sunIcon) sunIcon.classList.add('active');
        if (moonIcon) moonIcon.classList.remove('active');
    } else {
        document.body.classList.remove('dark-theme');
        if (sunIcon) sunIcon.classList.remove('active');
        if (moonIcon) moonIcon.classList.add('active');
    }
    
    // Theme toggle functionality
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function() {
            const isDark = document.body.classList.contains('dark-theme');
            
            if (isDark) {
                // Switch to light
                document.body.classList.remove('dark-theme');
                localStorage.setItem('theme', 'light');
                if (sunIcon) sunIcon.classList.remove('active');
                if (moonIcon) moonIcon.classList.add('active');
            } else {
                // Switch to dark
                document.body.classList.add('dark-theme');
                localStorage.setItem('theme', 'dark');
                if (sunIcon) sunIcon.classList.add('active');
                if (moonIcon) moonIcon.classList.remove('active');
            }
        });
    }
}

// ===== Sidebar Functions =====
function initializeSidebar() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuIcon = document.getElementById('menuIcon');
    const closeIcon = document.getElementById('closeIcon');
    
    if (mobileMenuBtn && sidebar && overlay) {
        mobileMenuBtn.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });
        
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        });
    }
}

// ===== Header Functions =====
function initializeHeader() {
    const notificationsBtn = document.getElementById('notificationsBtn');
    
    if (notificationsBtn) {
        notificationsBtn.addEventListener('click', function() {
            showToast('Notifications', 'You have 3 new notifications');
        });
    }
}

// ===== Tab Switching =====
function switchTab(tabName) {
    // Update URL without reload
    const url = new URL(window.location);
    url.searchParams.set('tab', tabName);
    window.history.pushState({}, '', url);
    
    // Update tab triggers
    document.querySelectorAll('.tab-trigger').forEach(trigger => {
        trigger.classList.remove('active');
    });
    document.querySelector(`.tab-trigger[onclick="switchTab('${tabName}')"]`)?.classList.add('active');
    
    // Update tab content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    document.getElementById(`${tabName}-tab`)?.classList.add('active');
}

// ===== Applications Tab =====
function initializeApplicationsTab() {
    const searchInput = document.getElementById('app-search');
    const statusFilter = document.getElementById('app-status-filter');
    const departmentFilter = document.getElementById('app-department-filter');
    const regionFilter = document.getElementById('app-region-filter');
    
    if (searchInput) {
        searchInput.addEventListener('input', filterApplications);
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', filterApplications);
    }
    if (departmentFilter) {
        departmentFilter.addEventListener('change', filterApplications);
    }
    if (regionFilter) {
        regionFilter.addEventListener('change', filterApplications);
    }
    
    filterApplications();
}

function filterApplications() {
    const searchQuery = document.getElementById('app-search')?.value.toLowerCase() || '';
    const statusFilter = document.getElementById('app-status-filter')?.value || 'all';
    const departmentFilter = document.getElementById('app-department-filter')?.value || 'all';
    const regionFilter = document.getElementById('app-region-filter')?.value || 'all';
    
    const filtered = applicationsData.filter(app => {
        const matchesSearch = app.applicantName.toLowerCase().includes(searchQuery) ||
                            app.email.toLowerCase().includes(searchQuery) ||
                            app.position.toLowerCase().includes(searchQuery);
        const matchesStatus = statusFilter === 'all' || app.status === statusFilter;
        const matchesDepartment = departmentFilter === 'all' || app.department === departmentFilter;
        const matchesRegion = regionFilter === 'all' || app.region === regionFilter;
        
        return matchesSearch && matchesStatus && matchesDepartment && matchesRegion;
    });
    
    currentAppPage = 1;
    renderApplicationsTable(filtered);
    updateApplicationsPagination(filtered);
}

function renderApplicationsTable(data) {
    const tbody = document.getElementById('applications-tbody');
    if (!tbody) return;
    
    const start = (currentAppPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageData = data.slice(start, end);
    
    tbody.innerHTML = '';
    
    pageData.forEach(app => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="table-cell-medium">${escapeHtml(app.applicantName)}</td>
            <td style="color: var(--color-muted-foreground);">${escapeHtml(app.email)}</td>
            <td>${escapeHtml(app.position)}</td>
            <td>${escapeHtml(app.department)}</td>
            <td>${escapeHtml(app.region)}</td>
            <td>${formatDate(app.dateSubmitted)}</td>
            <td><span class="badge badge-${app.status}">${capitalizeFirst(app.status)}</span></td>
            <td class="text-right">
                <div class="table-actions">
                    <button class="btn btn-ghost btn-sm" onclick='viewApplication(${JSON.stringify(app)})'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                    <button class="btn btn-ghost btn-sm" onclick='quickApprove("${app.id}")'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-success);">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </button>
                    <button class="btn btn-ghost btn-sm" onclick='quickReject("${app.id}")'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-error);">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
    
    document.getElementById('app-showing-count').textContent = data.length;
}

function updateApplicationsPagination(data) {
    const totalPages = Math.ceil(data.length / itemsPerPage);
    document.getElementById('app-pagination-info').textContent = `Page ${currentAppPage} of ${totalPages}`;
    document.getElementById('app-prev-btn').disabled = currentAppPage === 1;
    document.getElementById('app-next-btn').disabled = currentAppPage === totalPages;
}

function changeApplicationsPage(delta) {
    currentAppPage += delta;
    filterApplications();
}

function viewApplication(app) {
    currentApplication = app;
    document.getElementById('modalAppName').textContent = app.applicantName;
    document.getElementById('modalAppPosition').textContent = `${app.position} - ${app.department}`;
    
    const content = document.getElementById('modalAppContent');
    content.innerHTML = `
        <div class="expanded-details">
            <div class="detail-group">
                <label class="detail-label">Application ID</label>
                <p class="detail-value">${escapeHtml(app.id)}</p>
            </div>
            <div class="detail-group">
                <label class="detail-label">Email</label>
                <p class="detail-value">${escapeHtml(app.email)}</p>
            </div>
            <div class="detail-group">
                <label class="detail-label">Department</label>
                <p class="detail-value">${escapeHtml(app.department)}</p>
            </div>
            <div class="detail-group">
                <label class="detail-label">Region</label>
                <p class="detail-value">${escapeHtml(app.region)}</p>
            </div>
            <div class="detail-group">
                <label class="detail-label">Date Submitted</label>
                <p class="detail-value">${formatDate(app.dateSubmitted)}</p>
            </div>
            <div class="detail-group">
                <label class="detail-label">Status</label>
                <p class="detail-value"><span class="badge badge-${app.status}">${capitalizeFirst(app.status)}</span></p>
            </div>
            <div class="detail-group" style="grid-column: 1 / -1;">
                <label class="detail-label">Cover Letter</label>
                <p class="detail-value">${escapeHtml(app.coverLetter)}</p>
            </div>
            <div class="detail-group" style="grid-column: 1 / -1;">
                <label class="detail-label">Qualifications</label>
                <p class="detail-value">${escapeHtml(app.qualifications)}</p>
            </div>
            <div class="detail-group" style="grid-column: 1 / -1;">
                <label class="detail-label">CV/Resume</label>
                <p class="detail-value"><a href="${app.cv}" style="color: var(--color-accent-pink);">Download CV</a></p>
            </div>
        </div>
    `;
    
    openModal('applicationModal');
}

function handleApplicationAction(action) {
    if (!currentApplication) return;
    
    const actionText = action === 'approve' ? 'approved' : 'rejected';
    showToast(
        `Application ${capitalizeFirst(actionText)}`,
        `${currentApplication.applicantName}'s application has been ${actionText}.`
    );
    
    closeModal('applicationModal');
    filterApplications();
}

function quickApprove(id) {
    const app = applicationsData.find(a => a.id === id);
    if (app) {
        showToast('Application Approved', `${app.applicantName}'s application has been approved.`);
    }
}

function quickReject(id) {
    const app = applicationsData.find(a => a.id === id);
    if (app) {
        showToast('Application Rejected', `${app.applicantName}'s application has been rejected.`);
    }
}

function exportApplicationsToCSV() {
    showToast('Export Started', 'Your CSV file is being prepared for download.');
}

// ===== Donations Tab =====
function initializeDonationsTab() {
    const searchInput = document.getElementById('don-search');
    const paymentFilter = document.getElementById('don-payment-filter');
    const statusFilter = document.getElementById('don-status-filter');
    
    if (searchInput) {
        searchInput.addEventListener('input', filterDonations);
    }
    if (paymentFilter) {
        paymentFilter.addEventListener('change', filterDonations);
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', filterDonations);
    }
    
    filterDonations();
}

function filterDonations() {
    const searchQuery = document.getElementById('don-search')?.value.toLowerCase() || '';
    const paymentFilter = document.getElementById('don-payment-filter')?.value || 'all';
    const statusFilter = document.getElementById('don-status-filter')?.value || 'all';
    
    const filtered = donationsData.filter(don => {
        const matchesSearch = don.donorName.toLowerCase().includes(searchQuery) ||
                            don.email.toLowerCase().includes(searchQuery) ||
                            don.transactionId.toLowerCase().includes(searchQuery);
        const matchesPayment = paymentFilter === 'all' || don.paymentMethod === paymentFilter;
        const matchesStatus = statusFilter === 'all' || don.status === statusFilter;
        
        return matchesSearch && matchesPayment && matchesStatus;
    });
    
    currentDonPage = 1;
    renderDonationsTable(filtered);
    updateDonationsPagination(filtered);
}

function renderDonationsTable(data) {
    const tbody = document.getElementById('donations-tbody');
    if (!tbody) return;
    
    const start = (currentDonPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageData = data.slice(start, end);
    
    tbody.innerHTML = '';
    
    pageData.forEach(don => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="table-cell-medium">${escapeHtml(don.donorName)}</td>
            <td style="color: var(--color-muted-foreground);">${escapeHtml(don.email)}</td>
            <td class="table-cell-medium">UGX ${formatNumber(don.amount)}</td>
            <td>${escapeHtml(don.paymentMethod)}</td>
            <td class="table-cell-mono">${escapeHtml(don.transactionId)}</td>
            <td>${formatDate(don.date)}</td>
            <td><span class="badge badge-${don.status.toLowerCase()}">${don.status}</span></td>
            <td class="text-right">
                <div class="table-actions">
                    <button class="btn btn-ghost btn-sm" onclick='viewReceipt("${don.id}")' title="View Receipt">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                    </button>
                    <button class="btn btn-ghost btn-sm" onclick='sendThankYou("${don.donorName}")' title="Send Thank You">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
    
    document.getElementById('don-showing-count').textContent = data.length;
}

function updateDonationsPagination(data) {
    const totalPages = Math.ceil(data.length / itemsPerPage);
    document.getElementById('don-pagination-info').textContent = `Page ${currentDonPage} of ${totalPages}`;
    document.getElementById('don-prev-btn').disabled = currentDonPage === 1;
    document.getElementById('don-next-btn').disabled = currentDonPage === totalPages;
}

function changeDonationsPage(delta) {
    currentDonPage += delta;
    filterDonations();
}

function viewReceipt(id) {
    showToast('Receipt', 'Opening receipt for transaction ' + id);
}

function sendThankYou(donorName) {
    showToast('Thank You Email Sent', `A thank you email has been sent to ${donorName}.`);
}

function exportDonationsToExcel() {
    showToast('Export Started', 'Your Excel file is being prepared for download.');
}

// ===== Subscriptions Tab =====
function initializeSubscriptionsTab() {
    const searchInput = document.getElementById('sub-search');
    const statusFilter = document.getElementById('sub-status-filter');
    const regionFilter = document.getElementById('sub-region-filter');
    
    if (searchInput) {
        searchInput.addEventListener('input', filterSubscriptions);
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', filterSubscriptions);
    }
    if (regionFilter) {
        regionFilter.addEventListener('change', filterSubscriptions);
    }
    
    filterSubscriptions();
}

function filterSubscriptions() {
    const searchQuery = document.getElementById('sub-search')?.value.toLowerCase() || '';
    const statusFilter = document.getElementById('sub-status-filter')?.value || 'all';
    const regionFilter = document.getElementById('sub-region-filter')?.value || 'all';
    
    const filtered = subscriptionsData.filter(sub => {
        const matchesSearch = sub.subscriberName.toLowerCase().includes(searchQuery) ||
                            sub.email.toLowerCase().includes(searchQuery) ||
                            sub.phone.includes(searchQuery);
        const matchesStatus = statusFilter === 'all' || sub.status === statusFilter;
        const matchesRegion = regionFilter === 'all' || sub.region === regionFilter;
        
        return matchesSearch && matchesStatus && matchesRegion;
    });
    
    currentSubPage = 1;
    renderSubscriptionsTable(filtered);
    updateSubscriptionsPagination(filtered);
}

function renderSubscriptionsTable(data) {
    const tbody = document.getElementById('subscriptions-tbody');
    if (!tbody) return;
    
    const start = (currentSubPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageData = data.slice(start, end);
    
    tbody.innerHTML = '';
    
    pageData.forEach(sub => {
        const row = document.createElement('tr');
        const isChecked = selectedSubscriptions.has(sub.id);
        row.innerHTML = `
            <td>
                <input type="checkbox" class="checkbox" ${isChecked ? 'checked' : ''} 
                       onchange="toggleSubscriptionSelection('${sub.id}')">
            </td>
            <td class="table-cell-medium">${escapeHtml(sub.subscriberName)}</td>
            <td style="color: var(--color-muted-foreground);">${escapeHtml(sub.email)}</td>
            <td class="table-cell-mono">${escapeHtml(sub.phone)}</td>
            <td>${escapeHtml(sub.region)}</td>
            <td>${formatDate(sub.subscriptionDate)}</td>
            <td>
                <div class="flex items-center gap-2">
                    <span class="badge badge-${sub.status.toLowerCase()}">${sub.status}</span>
                    <label class="switch">
                        <input type="checkbox" ${sub.status === 'Active' ? 'checked' : ''} 
                               onchange='toggleSubscriptionStatus("${sub.id}")'>
                        <span class="switch-slider"></span>
                    </label>
                </div>
            </td>
            <td>${formatDate(sub.lastEmailSent)}</td>
            <td class="text-right">
                <div class="table-actions">
                    <button class="btn btn-ghost btn-sm" onclick='viewHistory("${sub.id}")' title="View History">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </button>
                    <button class="btn btn-ghost btn-sm" onclick='sendNewsletter("${sub.email}")' title="Send Newsletter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
    
    document.getElementById('sub-showing-count').textContent = data.length;
    updateBulkActionsVisibility();
}

function updateSubscriptionsPagination(data) {
    const totalPages = Math.ceil(data.length / itemsPerPage);
    document.getElementById('sub-pagination-info').textContent = `Page ${currentSubPage} of ${totalPages}`;
    document.getElementById('sub-prev-btn').disabled = currentSubPage === 1;
    document.getElementById('sub-next-btn').disabled = currentSubPage === totalPages;
}

function changeSubscriptionsPage(delta) {
    currentSubPage += delta;
    filterSubscriptions();
}

function toggleSubscriptionSelection(id) {
    if (selectedSubscriptions.has(id)) {
        selectedSubscriptions.delete(id);
    } else {
        selectedSubscriptions.add(id);
    }
    updateBulkActionsVisibility();
}

function toggleSelectAllSubscriptions() {
    const checkbox = document.getElementById('sub-select-all');
    const tbody = document.getElementById('subscriptions-tbody');
    const checkboxes = tbody.querySelectorAll('input[type="checkbox"]');
    
    checkboxes.forEach(cb => {
        const id = cb.getAttribute('onchange').match(/'([^']+)'/)[1];
        if (checkbox.checked) {
            selectedSubscriptions.add(id);
            cb.checked = true;
        } else {
            selectedSubscriptions.delete(id);
            cb.checked = false;
        }
    });
    
    updateBulkActionsVisibility();
}

function updateBulkActionsVisibility() {
    const bulkActions = document.getElementById('sub-bulk-actions');
    const selectedInfo = document.getElementById('sub-selected-info');
    
    if (selectedSubscriptions.size > 0) {
        bulkActions.style.display = 'flex';
        selectedInfo.textContent = ` (${selectedSubscriptions.size} selected)`;
        selectedInfo.classList.remove('hidden');
    } else {
        bulkActions.style.display = 'none';
        selectedInfo.classList.add('hidden');
    }
}

function toggleSubscriptionStatus(id) {
    const sub = subscriptionsData.find(s => s.id === id);
    if (sub) {
        const newStatus = sub.status === 'Active' ? 'Inactive' : 'Active';
        showToast('Status Updated', `${sub.subscriberName} is now ${newStatus}.`);
    }
}

function viewHistory(id) {
    showToast('History', 'Viewing subscription history for ' + id);
}

function sendNewsletter(email) {
    showToast('Newsletter Sent', `Newsletter has been sent to ${email}.`);
}

function sendNewsletterToSelected() {
    const count = selectedSubscriptions.size;
    showToast('Newsletter Sent', `Newsletter has been sent to ${count} subscriber${count !== 1 ? 's' : ''}.`);
    selectedSubscriptions.clear();
    filterSubscriptions();
}

function exportSelectedSubscriptions() {
    const count = selectedSubscriptions.size;
    showToast('Export Started', `Exporting ${count} selected subscribers.`);
}

// ===== Modal Functions =====
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
    }
}

// ===== Toast Notifications =====
function showToast(title, description) {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `
        <div class="toast-title">${escapeHtml(title)}</div>
        <div class="toast-description">${escapeHtml(description)}</div>
    `;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideIn 0.3s ease-out reverse';
        setTimeout(() => {
            container.removeChild(toast);
        }, 300);
    }, 3000);
}

// ===== Dashboard Charts =====
function initializeDashboardCharts() {
    if (typeof Chart === 'undefined' || 
        typeof donationsChartData === 'undefined' ||
        typeof applicationsChartData === 'undefined' ||
        typeof donationsDistributionData === 'undefined') {
        return;
    }
    
    // Get theme colors
    const isDark = document.body.classList.contains('dark-theme');
    const gridColor = isDark ? '#2A2A2A' : '#E5E7EB';
    const tickColor = isDark ? '#A0A0A0' : '#6B7280';
    const tooltipBg = isDark ? '#1A1A1A' : '#FFFFFF';
    const tooltipBorder = isDark ? '#2A2A2A' : '#E5E7EB';
    const tooltipText = isDark ? '#FFFFFF' : '#111827';
    
    // Donations Line Chart
    const donationsCtx = document.getElementById('donationsChart');
    if (donationsCtx) {
        new Chart(donationsCtx, {
            type: 'line',
            data: {
                labels: donationsChartData.map(d => d.month),
                datasets: [{
                    label: 'Donations (UGX)',
                    data: donationsChartData.map(d => d.amount),
                    borderColor: '#EC008C',
                    backgroundColor: 'rgba(236, 0, 140, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#EC008C',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText,
                        borderColor: tooltipBorder,
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return 'UGX ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            color: tickColor,
                            callback: function(value) {
                                return (value / 1000000).toFixed(1) + 'M';
                            }
                        },
                        grid: {
                            color: gridColor,
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            color: tickColor
                        },
                        grid: {
                            color: gridColor,
                            drawBorder: false
                        }
                    }
                }
            }
        });
    }
    
    // Applications Bar Chart
    const applicationsCtx = document.getElementById('applicationsChart');
    if (applicationsCtx) {
        new Chart(applicationsCtx, {
            type: 'bar',
            data: {
                labels: applicationsChartData.map(d => d.department),
                datasets: [{
                    label: 'Applications',
                    data: applicationsChartData.map(d => d.count),
                    backgroundColor: '#00AEEF',
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText,
                        borderColor: tooltipBorder,
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            color: tickColor,
                            stepSize: 2
                        },
                        grid: {
                            color: gridColor,
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            color: tickColor,
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    // Donations Distribution Pie Chart
    const distributionCtx = document.getElementById('distributionChart');
    if (distributionCtx) {
        new Chart(distributionCtx, {
            type: 'pie',
            data: {
                labels: donationsDistributionData.map(d => d.name),
                datasets: [{
                    data: donationsDistributionData.map(d => d.value),
                    backgroundColor: [
                        '#EC008C',
                        '#00AEEF',
                        '#10B981',
                        '#F59E0B',
                        '#A0A0A0'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: tickColor,
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText,
                        borderColor: tooltipBorder,
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(0);
                                return `${label}: ${percentage}%`;
                            }
                        }
                    }
                }
            }
        });
    }
}

// ===== Utility Functions =====
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return String(text).replace(/[&<>"']/g, m => map[m]);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function capitalizeFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

