<?php
require_once 'includes/session_helper.php';
$pageTitle = "Level 2: Command Concatenation";
include 'includes/header.php';

$ip = $_GET['ip'] ?? '';
$output = '';

if ($ip) {
    // Attempted security: Check if it starts with a digit or letter
    if (preg_match('/^[a-zA-Z0-0]/', $ip)) {
        // VULNERABLE: Still vulnerable to concatenation operators like &&, ||, ;
        $output = shell_exec("ping -c 1 " . $ip);
    } else {
        $output = "Error: Input must start with an alphanumeric character.";
    }
}
?>

<div class="box low">
    <span class="badge badge-low">Level 2: Low</span>
    <h2>Command Concatenation</h2>
    <p>The developer added a basic check to ensure the input starts with an alphanumeric character, but failed to block shell concatenation operators.</p>

    <h3>Source Code:</h3>
    <?php renderCodeSnippet('if (preg_match("/^[a-zA-Z0-9]/", $ip)) {
    echo shell_exec("ping -c 1 " . $ip);
}'); ?>

    <h3>Goal:</h3>
    <p>Use shell operators (<code>&&</code>, <code>||</code>, or <code>;</code>) to execute <code>uname -a</code> after the ping command.</p>

    <form method="GET" class="form-group">
        <label for="ip">Host to Check:</label>
        <input type="text" name="ip" id="ip" value="<?php echo htmlspecialchars($ip); ?>" placeholder="e.g. 8.8.8.8">
        <button type="submit" class="btn" style="margin-top: 15px;">Check Connectivity</button>
    </form>

    <?php if ($output): ?>
        <h3>Output:</h3>
        <div class="result-box"><?php echo htmlspecialchars($output); ?></div>
    <?php endif; ?>

    <a href="index.php" class="back-link">⬅️ Back to Dashboard</a>
</div>

<?php include 'includes/footer.php'; ?>
