<?php
require_once 'includes/session_helper.php';
$pageTitle = "Level 1: Classic Command Injection";
include 'includes/header.php';

$ip = $_GET['ip'] ?? '';
$output = '';

if ($ip) {
    // VULNERABLE: Direct concatenation into shell command
    $output = shell_exec("ping -c 3 " . $ip);
}
?>

<div class="box low">
    <span class="badge badge-low">Level 1: Low</span>
    <h2>Classic Command Injection</h2>
    <p>This network tool allows you to ping a host. However, it fails to sanitize your input before passing it to the system shell.</p>

    <h3>Source Code:</h3>
    <?php renderCodeSnippet('// VULNERABLE: Direct concatenation into shell command
$ip = $_GET["ip"];
echo shell_exec("ping -c 3 " . $ip);'); ?>

    <h3>Goal:</h3>
    <p>Execute the <code>id</code> command to see your current user and group privileges.</p>

    <form method="GET" class="form-group">
        <label for="ip">Target Host (IP or Domain):</label>
        <input type="text" name="ip" id="ip" value="<?php echo htmlspecialchars($ip); ?>" placeholder="e.g. 127.0.0.1">
        <button type="submit" class="btn" style="margin-top: 15px;">Run Diagnostics</button>
    </form>

    <?php if ($output): ?>
        <h3>Command Output:</h3>
        <div class="result-box"><?php echo htmlspecialchars($output); ?></div>
    <?php endif; ?>

    <a href="index.php" class="back-link">⬅️ Back to Dashboard</a>
</div>

<?php include 'includes/footer.php'; ?>
