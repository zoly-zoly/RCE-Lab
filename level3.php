<?php
require_once 'includes/session_helper.php';
$pageTitle = "Level 3: Character Blacklist";
include 'includes/header.php';

$ip = $_GET['ip'] ?? '';
$output = '';

if ($ip) {
    // Blacklist common command separators
    $blacklist = ['/', '&', '|', ';', '`', '$'];
    $filtered = str_replace($blacklist, '', $ip);
    
    // Check if blacklisted characters were removed or if we can still exploit via newline
    // Or if input contains forbidden chars
    $hasForbidden = false;
    foreach ($blacklist as $char) {
        if (strpos($ip, $char) !== false) {
            $hasForbidden = true;
            break;
        }
    }

    if ($hasForbidden) {
        $output = "WAF Alert: Forbidden characters detected!";
    } else {
        $output = shell_exec("ping -c 1 " . $ip);
    }
}
?>

<div class="box medium">
    <span class="badge badge-medium">Level 3: Medium</span>
    <h2>Character Blacklist</h2>
    <p>A simple WAF strips or blocks common command chaining characters (<code>/</code>, <code>&</code>, <code>|</code>, <code>;</code>, <code>`</code>, <code>$</code>). Can you find alternative ways to execute commands or bypass the filter?</p>

    <h3>Source Code:</h3>
    <?php renderCodeSnippet('$blacklist = ["/", "&", "|", ";", "`", "$"];
foreach ($blacklist as $char) {
    if (strpos($ip, $char) !== false) {
        die("WAF Alert: Forbidden characters detected!");
    }
}
echo shell_exec("ping -c 1 " . $ip);'); ?>

    <h3>Goal:</h3>
    <p>Bypass the blacklist filter (hint: newlines <code>%0a</code> or relative paths without slashes) to run <code>whoami</code>.</p>

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
