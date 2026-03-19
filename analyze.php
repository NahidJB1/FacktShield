<?php
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'], $_POST['type'])) {
    $content = trim($_POST['content']);
    $type = $_POST['type'];

    // Insert a placeholder record
    $stmt = $pdo->prepare("INSERT INTO articles (content_type, content, verdict, confidence, ai_summary) VALUES (?, ?, 'suspicious', 0, 'Processing...')");
    $stmt->execute([$type, $content]);
    $articleId = $pdo->lastInsertId();

    // Here you would normally call your AI model (or mock it)
    // For now, we'll simulate by updating the record after a short delay
    // In a real scenario, you might process asynchronously.
    // For demo, we can just update immediately with mock data.
    $mockVerdict = 'fake'; // You'd replace with actual AI result
    $mockConfidence = 91;
    $mockSummary = "This article contains false claims about vaccines.";
    $mockTx = "0x" . bin2hex(random_bytes(16)); // Fake blockchain tx

    $update = $pdo->prepare("UPDATE articles SET verdict = ?, confidence = ?, ai_summary = ?, blockchain_tx = ? WHERE id = ?");
    $update->execute([$mockVerdict, $mockConfidence, $mockSummary, $mockTx, $articleId]);

    // Insert some mock claims
    $claims = [
        ['claim' => 'The WHO confirmed vaccines cause autism.', 'verdict' => 'false', 'explanation' => 'WHO has never stated this.'],
        ['claim' => 'The original Wakefield study was published in The Lancet in 1998.', 'verdict' => 'true', 'explanation' => 'It was published but later retracted.'],
    ];
    foreach ($claims as $c) {
        $stmt = $pdo->prepare("INSERT INTO claims (article_id, claim_text, verdict, explanation) VALUES (?, ?, ?, ?)");
        $stmt->execute([$articleId, $c['claim'], $c['verdict'], $c['explanation']]);
        $claimId = $pdo->lastInsertId();
        // Insert mock sources for first claim
        if ($c['verdict'] === 'false') {
            $pdo->prepare("INSERT INTO sources (claim_id, source_name, source_url) VALUES (?, 'WHO', 'https://www.who.int')")->execute([$claimId]);
            $pdo->prepare("INSERT INTO sources (claim_id, source_name, source_url) VALUES (?, 'CDC', 'https://www.cdc.gov')")->execute([$claimId]);
        }
    }

    header("Location: results.php?id=" . $articleId);
    exit;
} else {
    // If someone accesses directly, redirect to home
    header("Location: /");
    exit;
}