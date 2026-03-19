<?php require_once 'includes/header.php'; ?>
<?php require_once 'includes/navbar.php'; ?>

<?php
// --- DYNAMIC DATA SIMULATION ---
// This simulates recent blockchain transactions
$transactions = [
    ['hash' => '0x480d2c0dfce...', 'block' => '448452936', 'age' => '12 secs ago', 'action' => 'Verify Fact', 'verdict' => 'Fake', 'vColor' => 'fake'],
    ['hash' => '0x9f8e7d6c5b4...', 'block' => '448452935', 'age' => '45 secs ago', 'action' => 'Verify Fact', 'verdict' => 'Real', 'vColor' => 'real'],
    ['hash' => '0x1a2b3c4d5e6...', 'block' => '448452931', 'age' => '2 mins ago', 'action' => 'Verify Fact', 'verdict' => 'Suspicious', 'vColor' => 'suspicious'],
    ['hash' => '0x7a8b9c0d1e2...', 'block' => '448452928', 'age' => '5 mins ago', 'action' => 'Verify Fact', 'verdict' => 'Real', 'vColor' => 'real'],
    ['hash' => '0x3f4e5d6c7b8...', 'block' => '448452920', 'age' => '12 mins ago', 'action' => 'Verify Fact', 'verdict' => 'Fake', 'vColor' => 'fake'],
    ['hash' => '0x0d9c8b7a6f5...', 'block' => '448452915', 'age' => '18 mins ago', 'action' => 'Verify Fact', 'verdict' => 'Fake', 'vColor' => 'fake'],
    ['hash' => '0x5e4d3c2b1a0...', 'block' => '448452901', 'age' => '25 mins ago', 'action' => 'Verify Fact', 'verdict' => 'Real', 'vColor' => 'real'],
];

// Top Stats
$networkStats = [
    ['label' => 'Network', 'value' => 'Polygon Mainnet'],
    ['label' => 'Total Verifications', 'value' => '21,238'],
    ['label' => 'Latest Block', 'value' => '448452936'],
];
?>

<main class="explorer-page">
    <div class="container">
        
        <div class="breadcrumbs">
            <a href="index.php">Home</a> > <span>Blockchain Explorer</span>
        </div>

        <div class="explorer-header">
            <div>
                <h1 class="landing-title" style="font-size: 3rem; margin-bottom: 8px;">Immutable Ledger</h1>
                <p class="landing-subtitle" style="margin-bottom: 0;">
                    <span class="live-dot-small" style="background-color: var(--accent-green); box-shadow: 0 0 10px var(--accent-green); animation: pulseGreen 2s infinite;"></span>
                    Live Polygon Network Status
                </p>
            </div>
            
            <div class="search-input-wrapper explorer-search">
                <span style="opacity: 0.5;">🔍</span>
                <input type="text" placeholder="Search by Txn Hash / Block / Article ID" class="journal-search">
            </div>
        </div>

        <div class="heatmap-stats-bar content-card" style="margin-bottom: 32px; grid-template-columns: repeat(3, 1fr);">
            <?php foreach($networkStats as $index => $stat): ?>
                <div class="h-stat-item <?= $index !== count($networkStats)-1 ? 'border-right' : '' ?>" style="padding: 24px;">
                    <p class="h-stat-label"><?= $stat['label'] ?></p>
                    <h3 class="h-stat-value text-cyan" style="font-size: 1.5rem;"><?= $stat['value'] ?></h3>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="content-card table-card">
            <div class="table-header-bar">
                <h3 class="card-title text-cyan" style="margin-bottom: 0;">Latest Transactions</h3>
                <button class="btn-outline-small">View All</button>
            </div>
            
            <div class="table-responsive">
                <table class="explorer-table">
                    <thead>
                        <tr>
                            <th>Txn Hash</th>
                            <th>Block</th>
                            <th>Age</th>
                            <th>Action</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($transactions as $txn): ?>
                            <tr>
                                <td>
                                    <div class="txn-cell">
                                        <span class="txn-icon">📄</span>
                                        <a href="#" class="txn-hash"><?= $txn['hash'] ?></a>
                                    </div>
                                </td>
                                <td><?= $txn['block'] ?></td>
                                <td><span style="color: var(--text-secondary);"><?= $txn['age'] ?></span></td>
                                <td><span class="action-badge"><?= $txn['action'] ?></span></td>
                                <td>
                                    <span class="claim-badge <?= $txn['vColor'] ?>" style="display: inline-block; text-align: center; min-width: 90px;">
                                        <?= $txn['verdict'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<?php require_once 'includes/footer.php'; ?>