<?php
require_once 'includes/session_helper.php';
$pageTitle = "Level 4: Restricted Shell Access";
include 'includes/header.php';

$ip = $_GET['ip'] ?? '';
$output = '';

if ($ip) {
    if (preg_match('/[\/\s]/', $ip)) {
        $output = "Security Error: Spaces and forward slashes are not allowed!";
    } else {
        $output = shell_exec("ping -c 1 " . $ip);
    }
}
?>

<div class="box medium">
    <span class="badge badge-medium">Level 4: Medium</span>
    <h2>Restricted Shell Access</h2>
    <p>Spaces and forward slashes (<code>/</code>) are strictly forbidden by the input validation filter. You will need to use alternative delimiters (like <code>${IFS}</code>) and encoding/variable techniques.</p>

    <h3>Source Code:</h3>
    <?php renderCodeSnippet('if (preg_match("/[\/\s]/", $ip)) {
    die("Security Error: Spaces and forward slashes are not allowed!");
}
echo shell_exec("ping -c 1 " . $ip);'); ?>

    <h3>Goal:</h3>
    <p>Execute <code>cat /etc/passwd</code> without using spaces or slashes (e.g. using <code>${IFS}</code> and hex/base64 or environment variables).</p>

    <form method="GET" class="form-group">
        <label for="ip">Target Host:</label>
        <input type="text" name="ip" id="ip" value="<?php echo htmlspecialchars($ip); ?>" placeholder="e.g. 127.0.0.1">
        <button type="submit" class="btn" style="margin-top: 15px;">Run Diagnostics</button>
    </form>

    <?php if ($output): ?>
        <h3>Output:</h3>
        <div class="result-box"><?php echo htmlspecialchars($output); ?></div>
    <?php endif; ?>

    <a href="index.php" class="back-link">⬅️ Back to Dashboard</a>
</div>

<?php include 'includes/footer.php'; ?>
