// Elpis Initiative Uganda - Admin Dashboard JavaScript
// Main functionality for all interactive features

// ===== Global State =====
window.currentAppPage = window.currentAppPage || 1;
window.currentDonPage = window.currentDonPage || 1;
window.currentSubPage = window.currentSubPage || 1;
window.itemsPerPage = window.itemsPerPage || 10;
window.selectedSubscriptions = window.selectedSubscriptions || new Set();
window.currentApplication = window.currentApplication || null;

// ===== Initialize on DOM Load =====
document.addEventListener('DOMContentLoaded', function () {
    initializeTheme();
    initializeSidebar();
    initializeHeader();

    // Dashboard → load live metrics and charts
    if (document.getElementById('donationsChart') || document.getElementById('applicationsChart')) {
        loadDashboardData();
    }

    // Management pages → load live data first, then init tabs
    if (document.getElementById('applications-tbody')) {
        fetchApplications().then(() => { populateApplicationFilters(); initializeApplicationsTab(); });
    }
    if (document.getElementById('donations-tbody')) {
        fetchDonations().then(() => { updateDonationsSummary(); initializeDonationsTab(); });
        const periodSelect = document.getElementById('don-period');
        if (periodSelect) periodSelect.addEventListener('change', updateDonationsSummary);
    }
    if (document.getElementById('subscriptions-tbody')) {
        fetchSubscriptions().then(() => { populateSubscriptionFilters(); initializeSubscriptionsTab(); });
    }
});

// ===== API Loaders =====
async function loadDashboardData() {
    try {
        // Overview metrics
        const overviewRes = await fetch('api/dashboard-stats.php?action=overview', { credentials: 'same-origin' });
        const overview = await overviewRes.json();
        if (overview?.success && overview.data) {
            // Update metric cards if present
            const metricNodes = document.querySelectorAll('.metrics-grid .metric-card .metric-info .metric-title');
            const valueNodes = document.querySelectorAll('.metrics-grid .metric-card .metric-info .metric-value');
            if (metricNodes.length >= 4 && valueNodes.length >= 4) {
                // Match by label text
                for (let i = 0; i < metricNodes.length; i++) {
                    const label = metricNodes[i].textContent.trim();
                    if (label === 'Total Applications') valueNodes[i].textContent = overview.data.total_applications;
                    if (label === 'Pending Applications') valueNodes[i].textContent = overview.data.pending_applications;
                    if (label === 'Total Donations') valueNodes[i].textContent = 'UGX ' + (Math.round((overview.data.total_donations || 0) / 100000) / 10).toFixed(1) + 'M';
                    if (label === 'Active Subscriptions') valueNodes[i].textContent = overview.data.active_subscriptions;
                }
            }
        }

        // Donations chart
        const donChartRes = await fetch('api/dashboard-stats.php?action=donations_chart', { credentials: 'same-origin' });
        const donChart = await donChartRes.json();
        if (donChart?.success) {
            window.donationsChartData = donChart.data.map(d => ({ month: d.month, amount: d.amount }));
        }

        // Applications chart
        const appChartRes = await fetch('api/dashboard-stats.php?action=applications_chart', { credentials: 'same-origin' });
        const appChart = await appChartRes.json();
        if (appChart?.success) {
            window.applicationsChartData = appChart.data.map(d => ({ department: d.department, count: d.count }));
        }

        // Distribution chart (by region via subscriptions)
        const distRes = await fetch('api/dashboard-stats.php?action=distribution', { credentials: 'same-origin' });
        const dist = await distRes.json();
        if (dist?.success) {
            window.donationsDistributionData = dist.data;
        }

        // Activity feed
        const activityRes = await fetch('api/dashboard-stats.php?action=activity', { credentials: 'same-origin' });
        const activity = await activityRes.json();
        if (activity?.success) {
            renderActivityFeed(activity.data || []);
        }

        // Initialize charts with available data (destroy previous instances if any)
        if (!window._charts) window._charts = {};
        initializeDashboardCharts();
    } catch (e) {
        console.error('Dashboard load error:', e);
    }
}

function renderActivityFeed(items) {
    const feed = document.querySelector('.activity-feed');
    if (!feed) return;
    if (!Array.isArray(items) || items.length === 0) {
        feed.innerHTML = '<div class="empty-state">No recent activity.</div>';
        return;
    }
    feed.innerHTML = '';
    items.forEach(a => {
        const item = document.createElement('div');
        item.className = 'activity-item';
        const icon = a.type === 'application' ?
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>' :
            (a.type === 'donation' ?
                '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>' :
                '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>');
        const statusIcon = a.status === 'success' ?
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>' :
            (a.status === 'error' ? '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>' : '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>');
        item.innerHTML = `
            <div class="activity-icon">${icon}</div>
            <div class="activity-content">
                <p class="activity-message">${escapeHtml(a.message)}</p>
                <p class="activity-timestamp">${escapeHtml(a.timestamp)}</p>
            </div>
            <div class="activity-status ${a.status}">${statusIcon}</div>
        `;
        feed.appendChild(item);
    });
}

async function fetchApplications() {
    try {
        const res = await fetch('api/applications.php?action=list&page=1&per_page=500', { credentials: 'same-origin' });
        const json = await res.json();
        const rows = (json?.success ? (json.data || []) : []).map(r => ({
            id: r.id,
            applicantName: r.applicant_name,
            email: r.email,
            phone: r.phone,
            position: r.position,
            department: r.department,
            region: r.region,
            dateSubmitted: r.date_submitted,
            status: r.status,
            reviewedBy: r.reviewed_by,
            reviewedAt: r.reviewed_at,
            // Optional detail fields if present
            coverLetter: r.cover_letter || '',
            qualifications: r.qualifications || '',
            cv: r.cv_file_path || ''
        }));
        window.applicationsData = rows;
    } catch (e) {
        console.error('Applications load error:', e);
        window.applicationsData = [];
    }
}
function populateApplicationFilters() {
    const departments = Array.from(new Set((window.applicationsData || []).map(a => a.department))).sort();
    const regions = Array.from(new Set((window.applicationsData || []).map(a => a.region))).sort();
    const deptSelect = document.getElementById('app-department-filter');
    const regionSelect = document.getElementById('app-region-filter');
    if (deptSelect && deptSelect.options.length <= 1) {
        departments.forEach(d => { const opt = document.createElement('option'); opt.value = d; opt.textContent = d; deptSelect.appendChild(opt); });
    }
    if (regionSelect && regionSelect.options.length <= 1) {
        regions.forEach(r => { const opt = document.createElement('option'); opt.value = r; opt.textContent = r; regionSelect.appendChild(opt); });
    }
}

async function fetchDonations() {
    try {
        const res = await fetch('api/donations.php?action=list&page=1&per_page=500', { credentials: 'same-origin' });
        const json = await res.json();
        const rows = (json?.success ? (json.data || []) : []).map(r => ({
            id: r.id,
            donorName: r.donor_name,
            email: r.email,
            phone: r.phone,
            amount: r.amount,
            paymentMethod: r.payment_method,
            transactionId: r.transaction_id,
            partnerId: r.partner_id,
            date: r.date,
            status: r.status,
            confirmationSent: r.confirmation_sent
        }));
        window.donationsData = rows;
    } catch (e) {
        console.error('Donations load error:', e);
        window.donationsData = [];
    }
}
function updateDonationsSummary() {
    const totalMonthEl = document.getElementById('don-total-month');
    const avgEl = document.getElementById('don-average');
    const popularEl = document.getElementById('don-popular-method');
    const periodSelect = document.getElementById('don-period');
    const period = periodSelect ? periodSelect.value : 'year';
    const labelEls = [
        document.getElementById('don-period-label'),
        document.getElementById('don-period-label-avg'),
        document.getElementById('don-period-label-pop')
    ];
    if (!Array.isArray(window.donationsData)) return;
    const now = new Date();
    let windowRows = window.donationsData;
    if (period === 'year') {
        const year = now.getFullYear();
        windowRows = windowRows.filter(d => (new Date(d.date)).getFullYear() === year && ['Success','Pending'].includes(d.status));
    } else {
        windowRows = windowRows.filter(d => ['Success','Pending'].includes(d.status));
    }
    const label = (period === 'year') ? 'This Year' : 'All Time';
    labelEls.forEach(el => { if (el) el.textContent = label; });
    const total30 = windowRows.reduce((s, d) => s + Number(d.amount || 0), 0);
    const avg = windowRows.length ? windowRows.reduce((s, d) => s + Number(d.amount || 0), 0) / windowRows.length : 0;
    const methodCount = {};
    windowRows.forEach(d => { methodCount[d.paymentMethod] = (methodCount[d.paymentMethod] || 0) + 1; });
    const popular = Object.entries(methodCount).sort((a, b) => b[1] - a[1])[0]?.[0] || '—';
    if (totalMonthEl) totalMonthEl.textContent = 'UGX ' + Number(total30).toLocaleString();
    if (avgEl) avgEl.textContent = 'UGX ' + Math.round(avg).toLocaleString();
    if (popularEl) popularEl.textContent = popular;
}

async function fetchSubscriptions() {
    try {
        const res = await fetch('api/subscriptions.php?action=list&page=1&per_page=500', { credentials: 'same-origin' });
        const json = await res.json();
        const rows = (json?.success ? (json.data || []) : []).map(r => ({
            id: r.id,
            subscriberName: r.subscriber_name,
            email: r.email,
            phone: r.phone,
            region: r.region,
            subscriptionDate: r.subscription_date,
            status: r.status,
            lastEmailSent: r.last_email_sent
        }));
        window.subscriptionsData = rows;
    } catch (e) {
        console.error('Subscriptions load error:', e);
        window.subscriptionsData = [];
    }
}
function populateSubscriptionFilters() {
    const regions = Array.from(new Set((window.subscriptionsData || []).map(s => s.region))).sort();
    const regionSelect = document.getElementById('sub-region-filter');
    if (regionSelect && regionSelect.options.length <= 1) {
        regions.forEach(r => { const opt = document.createElement('option'); opt.value = r; opt.textContent = r; regionSelect.appendChild(opt); });
    }
}

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
        themeToggleBtn.addEventListener('click', function () {
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
        mobileMenuBtn.addEventListener('click', function () {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        overlay.addEventListener('click', function () {
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
        notificationsBtn.addEventListener('click', function () {
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

    const filtered = (window.applicationsData || []).filter(app => {
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
            <td data-label="Applicant Name" class="table-cell-medium">${escapeHtml(app.applicantName)}</td>
            <td data-label="Email" style="color: var(--color-muted-foreground);">${escapeHtml(app.email)}</td>
            <td data-label="Position">${escapeHtml(app.position)}</td>
            <td data-label="Department">${escapeHtml(app.department)}</td>
            <td data-label="Region">${escapeHtml(app.region)}</td>
            <td data-label="Date">${formatDate(app.dateSubmitted)}</td>
            <td data-label="Status"><span class="badge badge-${app.status}">${capitalizeFirst(app.status)}</span></td>
            <td data-label="Actions" class="text-right">
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
    const status = action === 'approve' ? 'approved' : 'rejected';
    updateApplicationStatus(currentApplication.id, status, () => {
        showToast(
            'Application Updated',
            `${currentApplication.applicantName}'s application has been ${status}.`
        );
        closeModal('applicationModal');
        filterApplications();
    });
}

function quickApprove(id) {
    updateApplicationStatus(id, 'approved', () => {
        showToast('Application Updated', `Application ${id} approved.`);
        filterApplications();
    });
}

function quickReject(id) {
    updateApplicationStatus(id, 'rejected', () => {
        showToast('Application Updated', `Application ${id} rejected.`);
        filterApplications();
    });
}

function exportApplicationsToCSV() {
    window.location.href = 'api/applications.php?action=export';
}

// API action for applications
function updateApplicationStatus(id, status, onDone) {
    fetch('api/applications.php?action=update_status', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ id, status })
    }).then(r => r.json()).then(resp => {
        if (resp && resp.success) {
            const arr = window.applicationsData || [];
            const idx = arr.findIndex(a => a.id === id);
            if (idx >= 0) arr[idx].status = status;
            if (typeof onDone === 'function') onDone();
        } else {
            showToast('Update Failed', (resp && resp.message) || 'Could not update status');
        }
    }).catch(() => {
        showToast('Update Failed', 'Network error while updating.');
    });
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

    const filtered = (window.donationsData || []).filter(don => {
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
            <td data-label="Donor Name" class="table-cell-medium">${escapeHtml(don.donorName)}</td>
            <td data-label="Email" style="color: var(--color-muted-foreground);">${escapeHtml(don.email)}</td>
            <td data-label="Amount" class="table-cell-medium">UGX ${formatNumber(don.amount)}</td>
            <td data-label="Payment Method">${escapeHtml(don.paymentMethod)}</td>
            <td data-label="Transaction ID" class="table-cell-mono">${escapeHtml(don.transactionId)}</td>
            <td data-label="Date">${formatDate(don.date)}</td>
            <td data-label="Status"><span class="badge badge-${don.status.toLowerCase()}">${don.status}</span></td>
            <td data-label="Actions" class="text-right">
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

    const filtered = (window.subscriptionsData || []).filter(sub => {
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
            <td data-label="Select">
                <input type="checkbox" class="checkbox" ${isChecked ? 'checked' : ''} 
                       onchange="toggleSubscriptionSelection('${sub.id}')">
            </td>
            <td data-label="Name" class="table-cell-medium">${escapeHtml(sub.subscriberName)}</td>
            <td data-label="Email" style="color: var(--color-muted-foreground);">${escapeHtml(sub.email)}</td>
            <td data-label="Phone" class="table-cell-mono">${escapeHtml(sub.phone)}</td>
            <td data-label="Region">${escapeHtml(sub.region)}</td>
            <td data-label="Subscription Date">${formatDate(sub.subscriptionDate)}</td>
            <td data-label="Status">
                <div class="flex items-center gap-2">
                    <span class="badge badge-${sub.status.toLowerCase()}">${sub.status}</span>
                    <label class="switch">
                        <input type="checkbox" ${sub.status === 'Active' ? 'checked' : ''} 
                               onchange='toggleSubscriptionStatus("${sub.id}")'>
                        <span class="switch-slider"></span>
                    </label>
                </div>
            </td>
            <td data-label="Last Email">${formatDate(sub.lastEmailSent)}</td>
            <td data-label="Actions" class="text-right">
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
    const sub = (window.subscriptionsData || []).find(s => s.id === id);
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
    if (typeof Chart === 'undefined') return;

    const isDark = document.body.classList.contains('dark-theme');
    const gridColor = isDark ? '#2A2A2A' : '#E5E7EB';
    const tickColor = isDark ? '#A0A0A0' : '#6B7280';
    const tooltipBg = isDark ? '#1A1A1A' : '#FFFFFF';
    const tooltipBorder = isDark ? '#2A2A2A' : '#E5E7EB';
    const tooltipText = isDark ? '#FFFFFF' : '#111827';

    // Donations Line Chart
    const donationsCtx = document.getElementById('donationsChart');
    if (donationsCtx && Array.isArray(window.donationsChartData)) {
        if (window._charts.donations) { window._charts.donations.destroy(); }
        window._charts.donations = new Chart(donationsCtx, {
            type: 'line',
            data: {
                labels: window.donationsChartData.map(d => d.month),
                datasets: [{
                    label: 'Donations (UGX)',
                    data: window.donationsChartData.map(d => d.amount),
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
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText,
                        borderColor: tooltipBorder,
                        borderWidth: 1,
                        callbacks: { label: ctx => 'UGX ' + ctx.parsed.y.toLocaleString() }
                    }
                },
                scales: {
                    y: { ticks: { color: tickColor }, grid: { color: gridColor, drawBorder: false } },
                    x: { ticks: { color: tickColor }, grid: { color: gridColor, drawBorder: false } }
                }
            }
        });
    }

    // Applications Bar Chart
    const applicationsCtx = document.getElementById('applicationsChart');
    if (applicationsCtx && Array.isArray(window.applicationsChartData)) {
        if (window._charts.applications) { window._charts.applications.destroy(); }
        window._charts.applications = new Chart(applicationsCtx, {
            type: 'bar',
            data: {
                labels: window.applicationsChartData.map(d => d.department),
                datasets: [{
                    label: 'Applications',
                    data: window.applicationsChartData.map(d => d.count),
                    backgroundColor: '#00AEEF',
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: tooltipBg, titleColor: tooltipText, bodyColor: tooltipText, borderColor: tooltipBorder, borderWidth: 1 } },
                scales: {
                    y: { ticks: { color: tickColor }, grid: { color: gridColor, drawBorder: false } },
                    x: { ticks: { color: tickColor }, grid: { display: false } }
                }
            }
        });
    }

    // Donations Distribution Pie Chart (optional if data available)
    const distributionCtx = document.getElementById('distributionChart');
    if (distributionCtx && Array.isArray(window.donationsDistributionData)) {
        if (window._charts.distribution) { window._charts.distribution.destroy(); }
        window._charts.distribution = new Chart(distributionCtx, {
            type: 'pie',
            data: {
                labels: window.donationsDistributionData.map(d => d.name),
                datasets: [{
                    data: window.donationsDistributionData.map(d => d.value),
                    backgroundColor: ['#EC008C', '#00AEEF', '#10B981', '#F59E0B', '#A0A0A0'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { color: tickColor, padding: 15, font: { size: 12 } } },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText,
                        borderColor: tooltipBorder,
                        borderWidth: 1,
                        callbacks: {
                            label: function (context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total ? ((value / total) * 100).toFixed(0) : 0;
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

