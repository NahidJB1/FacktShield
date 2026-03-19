<?php require_once 'includes/header.php'; ?>
<?php require_once 'includes/navbar.php'; ?>

<?php
// --- DYNAMIC DATA SIMULATION ---
// This array mimics what your database will eventually return
$journalEntries = [
    [
        'category' => 'Health', 'catColor' => 'cyan',
        'verdict' => 'Fake', 'vColor' => 'fake',
        'title' => 'WHO confirms vaccines directly cause autism in children under 5...',
        'snippet' => 'A viral article claims WHO released a formal statement confirming a causal link between...',
        'date' => 'Jan 15, 2026'
    ],
    [
        'category' => 'Science', 'catColor' => 'green',
        'verdict' => 'Real', 'vColor' => 'real',
        'title' => 'NASA confirms discovery of water ice deposits near lunar new year...',
        'snippet' => 'Multiple peer-reviewed studies and NASA\'s official press release confirm the discovery...',
        'date' => 'Jan 14, 2026'
    ],
    [
        'category' => 'Politics', 'catColor' => 'yellow',
        'verdict' => 'Suspicious', 'vColor' => 'unverified',
        'title' => 'Leaked documents show planned governments future corruption...',
        'snippet' => 'Documents circulating online claim a major government is preparing mass surveillance...',
        'date' => 'Jan 13, 2026'
    ],
    [
        'category' => 'Finance', 'catColor' => 'yellow',
        'verdict' => 'Fake', 'vColor' => 'fake',
        'title' => 'Bitcoin just hit $500,000 — Elon Musk confirms he moved entire Tesla treasury...',
        'snippet' => 'A widely shared post claims Bitcoin reached an all-time high of $500,000 following a...',
        'date' => 'Jan 13, 2026'
    ],
    [
        'category' => 'War', 'catColor' => 'red',
        'verdict' => 'Fake', 'vColor' => 'fake',
        'title' => 'US officially declares war on China following South China Sea...',
        'snippet' => 'A fabricated news article claims the United States formally declared war on China...',
        'date' => 'Jan 12, 2026'
    ],
    [
        'category' => 'Health', 'catColor' => 'cyan',
        'verdict' => 'Real', 'vColor' => 'real',
        'title' => 'NASA confirms discovery of water ice deposits near lunar new year...',
        'snippet' => 'Multiple peer-reviewed studies and NASA\'s official press release confirm the discovery...',
        'date' => 'Jan 10, 2026'
    ]
];
?>

<main class="journal-page">
    <div class="container">
        
        <div class="breadcrumbs">
            <a href="index.php">Home</a> > <span>Journal</span>
        </div>

        <div class="journal-header">
            <h1 class="landing-title" style="font-size: 3.5rem; margin-bottom: 8px;">Fact Check Journal</h1>
            <p class="landing-subtitle" style="margin-bottom: 32px;">
                <span class="live-dot-small" style="background-color: var(--accent-green); box-shadow: 0 0 10px var(--accent-green); animation: pulseGreen 2s infinite;"></span>
                Browse all verified content. Updated in real time
            </p>
        </div>

        <div class="journal-filter-bar">
            <div class="search-input-wrapper">
                <span style="opacity: 0.5;">🔍</span>
                <input type="text" placeholder="Search verified articles" class="journal-search">
            </div>

            <div class="journal-filters">
                <div class="filter-group">
                    <span class="filter-label">Verdict</span>
                    <div class="filter-pills">
                        <button class="filter-pill active">All</button>
                        <button class="filter-pill pill-real"><span class="pill-dot bg-green"></span> Real</button>
                        <button class="filter-pill pill-fake"><span class="pill-dot bg-red"></span> Fake</button>
                        <button class="filter-pill pill-suspicious"><span class="pill-dot bg-yellow"></span> Suspicious</button>
                    </div>
                </div>
                
                <div class="filter-group dropdown-group border-left">
                    <div class="filter-dropdown">
                        <span class="filter-label">Category</span>
                        <select><option>All Categories</option></select>
                    </div>
                </div>
                
                <div class="filter-group dropdown-group border-left">
                    <div class="filter-dropdown">
                        <span class="filter-label">Sort</span>
                        <select><option>Newest First</option></select>
                    </div>
                </div>
            </div>
        </div>

        <p class="showing-results-text">Showing 1-9 of 1,204 verified articles</p>

        <div class="journal-grid">
            <?php foreach($journalEntries as $entry): ?>
                <div class="journal-card">
                    <div class="j-card-header">
                        <span class="j-category text-<?= $entry['catColor'] ?>"><?= $entry['category'] ?></span>
                        <span class="claim-badge <?= $entry['vColor'] ?>">✕ <?= $entry['verdict'] ?></span>
                    </div>
                    
                    <h3 class="j-card-title"><?= htmlspecialchars($entry['title']) ?></h3>
                    <p class="j-card-snippet"><?= htmlspecialchars($entry['snippet']) ?></p>
                    
                    <div class="j-card-footer">
                        <div class="j-meta">
                            <span style="display:block; margin-bottom:4px;"><?= $entry['date'] ?></span>
                            <span class="text-green" style="font-weight:600; font-size: 0.75rem;">BlockChain Verified</span>
                        </div>
                        <a href="results.php?id=1" class="j-view-link">View Report ↗</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="pagination">
            <button class="page-btn disabled">Previous</button>
            <button class="page-num active">1</button>
            <button class="page-num">2</button>
            <button class="page-num">3</button>
            <button class="page-num">4</button>
            <span class="page-dots">...</span>
            <button class="page-num">12</button>
            <button class="page-btn">Next ↗</button>
        </div>

    </div>
</main>

<?php require_once 'includes/footer.php'; ?>