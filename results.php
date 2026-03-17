<?php
require_once 'includes/config.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) {
    header("Location: /");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$article) {
    die("Article not found.");
}

// Fetch claims
$claimsStmt = $pdo->prepare("SELECT * FROM claims WHERE article_id = ?");
$claimsStmt->execute([$id]);
$claims = $claimsStmt->fetchAll(PDO::FETCH_ASSOC);

// For each claim, fetch sources
foreach ($claims as &$claim) {
    $sourceStmt = $pdo->prepare("SELECT * FROM sources WHERE claim_id = ?");
    $sourceStmt->execute([$claim['id']]);
    $claim['sources'] = $sourceStmt->fetchAll(PDO::FETCH_ASSOC);
}

require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<main class="results-page">
    <div class="container">
        <div class="result-header">
            <h1>Analysis Result</h1>
            <p class="analyzed-date">Analyzed on <?= date('d M Y, H:i', strtotime($article['analyzed_at'])) ?> UTC</p>
        </div>

        <div class="verdict-badge <?= $article['verdict'] ?>">
            <?= strtoupper($article['verdict']) ?> NEWS
        </div>

        <div class="ai-summary">
            <h2>AI Summary</h2>
            <p><?= htmlspecialchars($article['ai_summary']) ?></p>
        </div>

        <div class="claim-breakdown">
            <h2>Claim Breakdown</h2>
            <?php foreach ($claims as $index => $claim): ?>
                <div class="claim">
                    <div class="claim-header">
                        <span class="claim-number">Claim <?= $index+1 ?></span>
                        <span class="claim-verdict <?= $claim['verdict'] ?>"><?= ucfirst($claim['verdict']) ?></span>
                    </div>
                    <p class="claim-text"><?= htmlspecialchars($claim['claim_text']) ?></p>
                    <?php if (!empty($claim['explanation'])): ?>
                        <p class="claim-explanation"><strong>Why:</strong> <?= htmlspecialchars($claim['explanation']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($claim['sources'])): ?>
                        <div class="claim-sources">
                            <strong>Sources:</strong>
                            <ul>
                                <?php foreach ($claim['sources'] as $source): ?>
                                    <li><a href="<?= htmlspecialchars($source['source_url']) ?>" target="_blank"><?= htmlspecialchars($source['source_name']) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="blockchain-record">
            <h2>Blockchain Record</h2>
            <p>This result is permanently archived and tamper-proof.</p>
            <p><strong>Transaction ID:</strong> <code><?= htmlspecialchars($article['blockchain_tx']) ?></code></p>
            <p><a href="#" target="_blank">View on Blockchain Explorer →</a></p>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>