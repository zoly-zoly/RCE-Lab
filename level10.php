<?php
require_once 'includes/session_helper.php';
$pageTitle = "Level 10: Log Poisoning (Final Boss)";
include 'includes/header.php';

// Ensure log file exists
$logDir = 'logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0755, true);
}
$logFile = $logDir . '/access.log';
if (!file_exists($logFile)) {
    file_put_contents($logFile, "Access Log Initialized. User-Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown') . "\n");
}

$page = $_GET['page'] ?? '';
$output = '';

// Simulate logging user agent / request
$clientAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Mozilla/5.0';
@file_put_contents($logFile, "Log Entry - IP: " . $_SERVER['REMOTE_ADDR'] . " Agent: " . $clientAgent . "\n", FILE_APPEND);

if ($page) {
    // VULNERABLE: Local File Inclusion into log file
    ob_start();
    try {
        include($page);
        $output = ob_get_clean();
    } catch (Exception $e) {
        ob_end_clean();
        $output = "Error: " . $e->getMessage();
    }
}
?>

<div class="box elite">
    <span class="badge badge-elite">Level 10: Elite</span>
    <h2>Log Poisoning (Final Boss)</h2>
    <p>The application logs incoming HTTP User-Agent headers into a server log file and includes a page parameter via <code>include()</code>. Poison the log file with PHP code (via User-Agent header) and include the log to achieve RCE.</p>

    <h3>Source Code:</h3>
    <?php renderCodeSnippet('// Log incoming request
file_put_contents("logs/access.log", $_SERVER["HTTP_USER_AGENT"], FILE_APPEND);
// Unsafe inclusion
include($_GET["page"]);'); ?>

    <h3>Goal:</h3>
    <p>Poison <code>logs/access.log</code> with PHP code using your User-Agent header, then include <code>logs/access.log</code> via the <code>page</code> parameter to execute code.</p>

    <form method="GET" class="form-group">
        <label for="page">Include Log File:</label>
        <input type="text" name="page" id="page" value="<?php echo htmlspecialchars($page); ?>" placeholder="e.g. logs/access.log">
        <button type="submit" class="btn" style="margin-top: 15px;">Include File</button>
    </form>

    <?php if ($output): ?>
        <h3>Output:</h3>
        <div class="result-box"><?php echo htmlspecialchars($output); ?></div>
    <?php endif; ?>

    <a href="index.php" class="back-link">⬅️ Back to Dashboard</a>
</div>

<?php include 'includes/footer.php'; ?>
