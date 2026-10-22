<?php
session_start();

// Initialize session variables for specific levels if needed
if (!isset($_SESSION['rce_history'])) {
    $_SESSION['rce_history'] = [];
}

// Global flag/secret for learners to find
if (!isset($_COOKIE['SECRET_FLAG'])) {
    setcookie('SECRET_FLAG', 'RCE{MODERN_EXPLOITATION_MASTER}', time() + (86400 * 30), "/");
}

function renderCodeSnippet($code) {
    echo '<pre><code>' . htmlspecialchars($code) . '</code></pre>';
}
?>
