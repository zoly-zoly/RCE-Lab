<?php
require_once 'includes/session_helper.php';
$pageTitle = "Level 9: PHP Filter Chain";
include 'includes/header.php';

$page = $_GET['page'] ?? '';
$output = '';

if ($page) {
    // VULNERABLE: Unsafe include allowing php://filter streams
    ob_start();
    try {
        include($page);
        $output = ob_get_clean();
    } catch (Exception $e) {
        ob_end_clean();
        $output = "Error including file: " . $e->getMessage();
    }
}
?>

<div class="box critical">
    <span class="badge badge-critical">Level 9: Expert</span>
    <h2>PHP Filter Chain</h2>
    <p>No file upload functionality exists, but the application includes user-supplied file parameters using <code>include()</code>. You can construct a PHP filter chain stream (<code>php://filter</code>) to generate arbitrary code in memory without writing files to disk.</p>

    <h3>Source Code:</h3>
    <?php renderCodeSnippet('include($_GET["page"]);'); ?>

    <h3>Goal:</h3>
    <p>Use sophisticated PHP filter chains to generate a webshell via stream wrappers and execute code.</p>

    <form method="GET" class="form-group">
        <label for="page">Page / Stream Path:</label>
        <input type="text" name="page" id="page" value="<?php echo htmlspecialchars($page); ?>" placeholder="e.g. php://filter/.../resource=index.php">
        <button type="submit" class="btn" style="margin-top: 15px;">Load Stream</button>
    </form>

    <?php if ($output): ?>
        <h3>Output / Included Content:</h3>
        <div class="result-box"><?php echo htmlspecialchars($output); ?></div>
    <?php endif; ?>

    <a href="index.php" class="back-link">⬅️ Back to Dashboard</a>
</div>

<?php include 'includes/footer.php'; ?>
