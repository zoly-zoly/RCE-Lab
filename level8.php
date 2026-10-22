<?php
require_once 'includes/session_helper.php';
$pageTitle = "Level 8: Server-Side Template Injection";
include 'includes/header.php';

$template = $_GET['template'] ?? 'Hello Guest';
$output = '';

if ($template) {
    // Mock template engine evaluation (vulnerable to SSTI)
    // Evaluates double curly braces {{code}}
    $output = preg_replace_callback('/\{\{(.*?)\}\}/', function($matches) {
        $code = $matches[1];
        $evalResult = '';
        @eval('$evalResult = ' . $code . ';');
        return $evalResult;
    }, $template);
}
?>

<div class="box critical">
    <span class="badge badge-critical">Level 8: Expert</span>
    <h2>Server-Side Template Injection</h2>
    <p>A dynamic notification service renders user templates using a custom template parser that evaluates expressions inside double curly braces <code>{{ ... }}</code>.</p>

    <h3>Source Code:</h3>
    <?php renderCodeSnippet('$output = preg_replace_callback("/\\{\\{(.*?)\\}\\}/", function($matches) {
    @eval(\'$evalResult = \' . $matches[1] . \';\');
    return $evalResult;
}, $template);'); ?>

    <h3>Goal:</h3>
    <p>Inject PHP code inside <code>{{ ... }}</code> to execute <code>system('uname -a')</code>.</p>

    <form method="GET" class="form-group">
        <label for="template">Template Content:</label>
        <input type="text" name="template" id="template" value="<?php echo htmlspecialchars($template); ?>" placeholder="e.g. Hello {{ 7 * 7 }}">
        <button type="submit" class="btn" style="margin-top: 15px;">Render Template</button>
    </form>

    <?php if ($output): ?>
        <h3>Rendered Output:</h3>
        <div class="result-box"><?php echo htmlspecialchars($output); ?></div>
    <?php endif; ?>

    <a href="index.php" class="back-link">⬅️ Back to Dashboard</a>
</div>

<?php include 'includes/footer.php'; ?>
