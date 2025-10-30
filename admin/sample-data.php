<?php
// Sample data generation for Elpis Initiative Uganda Admin Dashboard

function randomDate($start, $end) {
    $timestamp = mt_rand($start, $end);
    return date('Y-m-d H:i:s', $timestamp);
}

// Departments, Regions, and Positions
$departments = ["Education", "Healthcare", "Community Development", "Finance", "Operations", "Marketing"];
$regions = ["Kampala", "Wakiso", "Mukono", "Jinja", "Mbarara", "Gulu", "Lira", "Mbale"];
$positions = [
    "Program Officer",
    "Field Coordinator",
    "Project Manager",
    "Finance Officer",
    "Communications Specialist",
    "Community Mobilizer"
];
$statuses = ["pending", "approved", "rejected"];

// Ugandan names for applications
$ugandanNames = [
    "Sarah Nakato", "John Okello", "Mary Nambi", "David Mugisha", "Grace Atim",
    "Peter Ssemakula", "Jane Akello", "Moses Kato", "Ruth Nalubega", "Samuel Opio",
    "Rebecca Namusoke", "Joseph Tumusiime", "Esther Auma", "Daniel Wasswa", "Faith Namukasa",
    "Isaac Byaruhanga", "Lydia Achan", "Emmanuel Kiiza", "Agnes Nabirye", "Patrick Odongo",
    "Catherine Namuli", "Francis Okoth", "Juliet Nakimuli", "Andrew Mwesigwa", "Stella Aber",
    "Richard Ssali", "Doreen Akot", "Henry Lubega", "Brenda Nakabugo", "Vincent Oloya",
    "Christine Nambozo", "George Wanyama", "Harriet Namatovu", "Simon Okumu", "Josephine Nabirye",
    "Michael Kiggundu", "Florence Adong", "Paul Mukasa", "Betty Namuddu", "Charles Ochen",
    "Irene Nakawuki", "Robert Opolot", "Winnie Nakalembe", "Fred Okello", "Mercy Akello",
    "James Ssekandi", "Patience Apio", "Martin Kisakye", "Diana Namuyanja", "Kenneth Otim"
];

// Generate 50 Applications
$applications = [];
$startDate = strtotime('2024-07-01');
$endDate = time();

for ($i = 0; $i < 50; $i++) {
    $applications[] = [
        'id' => 'APP-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
        'applicantName' => $ugandanNames[$i],
        'email' => 'applicant' . ($i + 1) . '@email.com',
        'position' => $positions[array_rand($positions)],
        'department' => $departments[array_rand($departments)],
        'region' => $regions[array_rand($regions)],
        'dateSubmitted' => randomDate($startDate, $endDate),
        'status' => $statuses[array_rand($statuses)],
        'cv' => '/documents/cv-' . ($i + 1) . '.pdf',
        'coverLetter' => 'I am writing to express my strong interest in this position. With my background in community development and proven track record of delivering impactful programs, I believe I would be a valuable addition to your team.',
        'qualifications' => "Bachelor's Degree in relevant field, 3+ years experience in NGO sector, Strong communication and project management skills, Proficiency in MS Office and data management systems."
    ];
}

// Generate 100 Donations
$donations = [];
$paymentMethods = ["Mobile Money", "Bank", "Card"];
$donationStatuses = ["Success", "Pending", "Failed"];

for ($i = 0; $i < 100; $i++) {
    $amount = rand(10000, 500000);
    // 90% success rate, 5% pending, 5% failed
    $statusRand = rand(1, 100);
    if ($statusRand <= 90) {
        $donationStatus = "Success";
    } elseif ($statusRand <= 95) {
        $donationStatus = "Pending";
    } else {
        $donationStatus = "Failed";
    }
    
    $donations[] = [
        'id' => 'DON-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
        'donorName' => 'Donor ' . ($i + 1),
        'email' => 'donor' . ($i + 1) . '@email.com',
        'amount' => $amount,
        'paymentMethod' => $paymentMethods[array_rand($paymentMethods)],
        'transactionId' => 'TXN' . strtoupper(substr(md5(mt_rand()), 0, 12)),
        'date' => randomDate($startDate, $endDate),
        'status' => $donationStatus
    ];
}

// Generate 200 Subscriptions
$subscriptions = [];
$subscriptionStatuses = ["Active", "Inactive"];

for ($i = 0; $i < 200; $i++) {
    $phoneNumber = '+256' . rand(700000000, 799999999);
    $status = (rand(1, 100) <= 80) ? "Active" : "Inactive"; // 80% active
    
    $subscriptions[] = [
        'id' => 'SUB-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
        'subscriberName' => 'Subscriber ' . ($i + 1),
        'email' => 'subscriber' . ($i + 1) . '@email.com',
        'phone' => $phoneNumber,
        'region' => $regions[array_rand($regions)],
        'subscriptionDate' => randomDate(strtotime('2023-01-01'), $endDate),
        'status' => $status,
        'lastEmailSent' => randomDate(strtotime('2024-10-01'), $endDate)
    ];
}

// Activity Feed Data
$activities = [
    [
        'id' => '1',
        'type' => 'application',
        'message' => 'New application from Sarah Nakato for Program Officer',
        'timestamp' => date('Y-m-d H:i:s', time() - (5 * 60)),
        'status' => 'pending'
    ],
    [
        'id' => '2',
        'type' => 'donation',
        'message' => 'Donation of UGX 250,000 received from John Doe',
        'timestamp' => date('Y-m-d H:i:s', time() - (15 * 60)),
        'status' => 'success'
    ],
    [
        'id' => '3',
        'type' => 'application',
        'message' => 'Application approved for David Mugisha',
        'timestamp' => date('Y-m-d H:i:s', time() - (30 * 60)),
        'status' => 'success'
    ],
    [
        'id' => '4',
        'type' => 'subscription',
        'message' => 'New newsletter subscription from Grace Atim',
        'timestamp' => date('Y-m-d H:i:s', time() - (45 * 60)),
        'status' => 'success'
    ],
    [
        'id' => '5',
        'type' => 'donation',
        'message' => 'Donation of UGX 100,000 from Mary Nambi',
        'timestamp' => date('Y-m-d H:i:s', time() - (60 * 60)),
        'status' => 'success'
    ],
    [
        'id' => '6',
        'type' => 'application',
        'message' => 'Application rejected for Peter Ssemakula',
        'timestamp' => date('Y-m-d H:i:s', time() - (90 * 60)),
        'status' => 'error'
    ],
    [
        'id' => '7',
        'type' => 'donation',
        'message' => 'Donation of UGX 500,000 received from Anonymous',
        'timestamp' => date('Y-m-d H:i:s', time() - (120 * 60)),
        'status' => 'success'
    ],
    [
        'id' => '8',
        'type' => 'subscription',
        'message' => 'Newsletter sent to 150 subscribers',
        'timestamp' => date('Y-m-d H:i:s', time() - (180 * 60)),
        'status' => 'success'
    ],
    [
        'id' => '9',
        'type' => 'application',
        'message' => 'New application from Jane Akello for Field Coordinator',
        'timestamp' => date('Y-m-d H:i:s', time() - (240 * 60)),
        'status' => 'pending'
    ],
    [
        'id' => '10',
        'type' => 'donation',
        'message' => 'Donation of UGX 75,000 from Moses Kato',
        'timestamp' => date('Y-m-d H:i:s', time() - (300 * 60)),
        'status' => 'success'
    ]
];

// Chart Data
$donationsChartData = [
    ['month' => 'Jul', 'amount' => 4500000],
    ['month' => 'Aug', 'amount' => 5200000],
    ['month' => 'Sep', 'amount' => 4800000],
    ['month' => 'Oct', 'amount' => 6100000],
    ['month' => 'Nov', 'amount' => 5900000],
    ['month' => 'Dec', 'amount' => 7200000]
];

$applicationsChartData = [
    ['department' => 'Education', 'count' => 12],
    ['department' => 'Healthcare', 'count' => 8],
    ['department' => 'Community Dev', 'count' => 10],
    ['department' => 'Finance', 'count' => 6],
    ['department' => 'Operations', 'count' => 7],
    ['department' => 'Marketing', 'count' => 7]
];

$donationsDistributionData = [
    ['name' => 'Kampala', 'value' => 35],
    ['name' => 'Wakiso', 'value' => 25],
    ['name' => 'Mukono', 'value' => 15],
    ['name' => 'Jinja', 'value' => 10],
    ['name' => 'Others', 'value' => 15]
];

// Helper function to format timestamp
function formatTimestamp($timestamp) {
    $now = time();
    $diff = $now - strtotime($timestamp);
    $minutes = floor($diff / 60);
    $hours = floor($minutes / 60);
    $days = floor($hours / 24);
    
    if ($minutes < 60) return $minutes . 'm ago';
    if ($hours < 24) return $hours . 'h ago';
    return $days . 'd ago';
}

// Export variables for use in other files
?>

