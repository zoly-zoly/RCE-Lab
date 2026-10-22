<?php
require_once 'includes/session_helper.php';
$pageTitle = "Level 5: Dynamic Calculator";
include 'includes/header.php';

$expr = $_GET['expr'] ?? '';
$output = '';

if ($expr) {
    // VULNERABLE: Using eval() on user input for a math calculator
    // Example vulnerable pattern: eval("return " . $expr . ";");
    @eval('$output = ' . $expr . ';');
    if ($output === null || $output === false) {
        $output = "Calculation Error or Invalid Expression.";
    }
}
?>

<div class="box high">
    <span class="badge badge-high">Level 5: High</span>
    <h2>Dynamic Calculator</h2>
    <p>This web application evaluates mathematical expressions dynamically using PHP's <code>eval()</code> function. However, improper sanitization allows PHP code execution.</p>

    <h3>Source Code:</h3>
    <?php renderCodeSnippet('@eval(\'$output = \' . $expr . \';\');'); ?>

    <h3>Goal:</h3>
    <p>Escape the string/expression context and execute <code>system('id')</code> or read a file using PHP functions.</p>

    <form method="GET" class="form-group">
        <label for="expr">Mathematical Expression:</label>
        <input type="text" name="expr" id="expr" value="<?php echo htmlspecialchars($expr); ?>" placeholder="e.g. 5 * 5">
        <button type="submit" class="btn" style="margin-top: 15px;">Calculate</button>
    </form>

    <?php if ($output): ?>
        <h3>Result:</h3>
        <div class="result-box"><?php echo htmlspecialchars(print_r($output, true)); ?></div>
    <?php endif; ?>

    <a href="index.php" class="back-link">⬅️ Back to Dashboard</a>
</div>

<?php include 'includes/footer.php'; ?>
