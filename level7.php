<?php
require_once 'includes/session_helper.php';
$pageTitle = "Level 7: Insecure Deserialization";
include 'includes/header.php';

class LoggerClass {
    public $logFile = 'app.log';
    public $logMessage = 'Default Log Entry';

    public function __destruct() {
        // VULNERABLE: __destruct magic method executes system command or writes arbitrary file
        if ($this->logFile && $this->logMessage) {
            @eval($this->logMessage);
        }
    }
}

$data = $_GET['data'] ?? '';
$output = '';

if ($data) {
    // VULNERABLE: unserialize on untrusted input
    $unserialized = @unserialize(base64_decode($data));
    $output = "Deserialization attempted. Check object behavior.";
} else {
    // Generate sample serialized payload for demonstration
    $sampleObj = new LoggerClass();
    $sampleObj->logMessage = "echo 'Executed via __destruct!';";
    $samplePayload = base64_encode(serialize($sampleObj));
}
?>

<div class="box high">
    <span class="badge badge-high">Level 7: High</span>
    <h2>Insecure Deserialization</h2>
    <p>The application unsafely deserializes user-supplied objects. By crafting a malicious serialized object, you can leverage PHP magic methods (like <code>__destruct</code>) to trigger RCE.</p>

    <h3>Source Code:</h3>
    <?php renderCodeSnippet('class LoggerClass {
    public $logMessage;
    public function __destruct() {
        @eval($this->logMessage);
    }
}
$obj = unserialize(base64_decode($_GET["data"]));'); ?>

    <h3>Goal:</h3>
    <p>Craft a base64-encoded serialized payload containing <code>system('id')</code> to execute system commands.</p>
    <?php if (isset($samplePayload)): ?>
        <p>Example sample payload base64: <code><?php echo $samplePayload; ?></code></p>
    <?php endif; ?>

    <form method="GET" class="form-group">
        <label for="data">Serialized Payload (Base64):</label>
        <input type="text" name="data" id="data" value="<?php echo htmlspecialchars($data); ?>" placeholder="e.g. TzoxMToiTG9nZ2VyQ2xhc3MiOjI...==">
        <button type="submit" class="btn" style="margin-top: 15px;">Process Object</button>
    </form>

    <?php if ($output): ?>
        <h3>Status:</h3>
        <div class="result-box"><?php echo htmlspecialchars($output); ?></div>
    <?php endif; ?>

    <a href="index.php" class="back-link">⬅️ Back to Dashboard</a>
</div>

<?php include 'includes/footer.php'; ?>
