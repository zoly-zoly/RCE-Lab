<?php
require_once 'includes/session_helper.php';
$pageTitle = "Level 6: Blind RCE";
include 'includes/header.php';

$ip = $_GET['ip'] ?? '';
$executed = false;

if ($ip) {
    // VULNERABLE: Output is discarded to /dev/null
    shell_exec("ping -c 1 " . $ip . " > /dev/null 2>&1");
    $executed = true;
}
?>

<div class="box high">
    <span class="badge badge-high">Level 6: High</span>
    <h2>Blind RCE</h2>
    <p>The system executes your command, but output is discarded. You must rely on time-based techniques (e.g. <code>sleep 5</code>) or Out-of-Band (OAST) callbacks to confirm execution.</p>

    <h3>Source Code:</h3>
    <?php renderCodeSnippet('shell_exec("ping -c 1 " . $ip . " > /dev/null 2>&1");'); ?>

    <h3>Goal:</h3>
    <p>Use time delays or DNS lookups (e.g., <code>nslookup</code> or <code>sleep</code>) to verify blind command execution.</p>

    <form method="GET" class="form-group">
        <label for="ip">Target Host:</label>
        <input type="text" name="ip" id="ip" value="<?php echo htmlspecialchars($ip); ?>" placeholder="e.g. 127.0.0.1">
        <button type="submit" class="btn" style="margin-top: 15px;">Send Ping</button>
    </form>

    <?php if ($executed): ?>
        <h3>Status:</h3>
        <div class="result-box">Command executed successfully (Output discarded). Response time analyzed.</div>
    <?php endif; ?>

    <a href="index.php" class="back-link">⬅️ Back to Dashboard</a>
</div>

<?php include 'includes/footer.php'; ?>
