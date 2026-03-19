<?php require_once 'includes/header.php'; ?>
<?php require_once 'includes/navbar.php'; ?>

<?php
// --- DYNAMIC DATA SIMULATION ---
// Replace these arrays with your actual database queries later.

$stats = [
    ['label' => 'Active Hotspots', 'value' => '39', 'sub' => 'Across 6 regions', 'color' => 'red'],
    ['label' => 'Most Affected', 'value' => 'Middle East', 'sub' => '3,241 active fake items', 'color' => 'cyan'],
    ['label' => 'Top Topic', 'value' => 'Politics', 'sub' => '38% of all misinformation', 'color' => 'yellow'],
    ['label' => 'New Today', 'value' => '12,789', 'sub' => 'Fake articles detected', 'color' => 'green']
];

$topMisinformation = [
    [
        'title' => 'Israeli Leader died on an air attack from Iran',
        'status' => 'Unverified', 'topic' => 'Politics', 'shares' => '84,201'
    ],
    [
        'title' => 'Military coup planned in three countries simultaneously — leaked documents',
        'status' => 'False', 'topic' => 'Politics', 'shares' => '94,801'
    ],
    [
        'title' => 'Government secretly banning cash transactions across Yemen by March',
        'status' => 'False', 'topic' => 'Finance', 'shares' => '32,081'
    ]
];

// Map Hotspots (x, y coordinates as percentages to remain perfectly responsive)
$hotspots = [
    ['x' => 22, 'y' => 35, 'intensity' => 'critical'], // North America
    ['x' => 28, 'y' => 65, 'intensity' => 'high'],     // South America
    ['x' => 25, 'y' => 80, 'intensity' => 'moderate'], // South America
    ['x' => 52, 'y' => 30, 'intensity' => 'high'],     // Europe
    ['x' => 58, 'y' => 45, 'intensity' => 'critical'], // Middle East
    ['x' => 62, 'y' => 42, 'intensity' => 'critical'], // Middle East
    ['x' => 65, 'y' => 55, 'intensity' => 'moderate'], // Africa
    ['x' => 75, 'y' => 35, 'intensity' => 'critical'], // Asia
    ['x' => 82, 'y' => 45, 'intensity' => 'moderate'], // Asia
];

$topics = ['All', 'Health', 'Politics', 'War', 'Finance', 'Science'];
?>

<main class="heatmap-page">
    <div class="container">
        
        <div class="breadcrumbs">
            <a href="index.php">Home</a> > <span>Heatmap</span>
        </div>

        <div class="heatmap-header">
            <h1 class="landing-title" style="font-size: 3.5rem; margin-bottom: 8px;">
                <span class="live-dot-large"></span> Misinformation Heatmap
            </h1>
            <p class="landing-subtitle" style="margin-bottom: 24px;">See where fake news is spreading right now across the globe.</p>
        </div>

        <div class="heatmap-filters">
            <div class="filter-group">
                <span class="filter-label">Topic:</span>
                <div class="filter-pills">
                    <?php foreach($topics as $index => $topic): ?>
                        <button class="filter-pill <?= $index === 0 ? 'active' : '' ?>"><?= $topic ?></button>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="filter-group dropdown-group">
                <div class="filter-dropdown">
                    <span class="filter-label">Time</span>
                    <select><option>Today</option><option>This Week</option></select>
                </div>
                <div class="filter-dropdown">
                    <span class="filter-label">Region</span>
                    <select><option>Global</option><option>Middle East</option></select>
                </div>
            </div>
        </div>

        <div class="heatmap-grid">
            
            <div class="map-section content-card">
                <div class="map-container">
                    <img src="assets/images/world.svg" alt="World Map" class="world-map-img" style="width:100%; opacity:0.8;">
                    
                    <?php foreach($hotspots as $spot): ?>
                        <div class="hotspot <?= $spot['intensity'] ?>" style="left: <?= $spot['x'] ?>%; top: <?= $spot['y'] ?>%;"></div>
                    <?php endforeach; ?>

                    <div class="map-legend">
                        <h4>INTENSITY</h4>
                        <ul>
                            <li><span class="legend-dot critical"></span> Critical</li>
                            <li><span class="legend-dot high"></span> High</li>
                            <li><span class="legend-dot moderate"></span> Moderate</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="heatmap-sidebar content-card">
                <h3 class="sidebar-title">
                    <span class="live-dot-small"></span> Top Misinformation <span class="region-focus">-Middle east</span>
                </h3>

                <div class="misinfo-list">
                    <?php foreach($topMisinformation as $item): ?>
                        <div class="misinfo-card">
                            <div class="misinfo-header">
                                <h4 class="misinfo-title"><?= htmlspecialchars($item['title']) ?></h4>
                                <span class="claim-badge <?= strtolower($item['status']) ?>"><?= $item['status'] ?></span>
                            </div>
                            
                            <div class="misinfo-footer">
                                <span class="misinfo-topic"><?= $item['topic'] ?></span>
                                <div class="misinfo-stats">
                                    <span class="shares"><?= $item['shares'] ?> shares in 24hrs</span>
                                    <a href="#" class="view-source-link">View Source</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="btn-outline w-100" style="margin-top: 24px;">View All Journals</button>
            </div>
        </div>

        <div class="heatmap-stats-bar content-card">
            <?php foreach($stats as $index => $stat): ?>
                <div class="h-stat-item <?= $index !== count($stats)-1 ? 'border-right' : '' ?>">
                    <p class="h-stat-label"><?= $stat['label'] ?></p>
                    <h3 class="h-stat-value text-<?= $stat['color'] ?>"><?= $stat['value'] ?></h3>
                    <p class="h-stat-sub"><?= $stat['sub'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</main>

<?php require_once 'includes/footer.php'; ?>