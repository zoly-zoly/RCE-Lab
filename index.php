<?php
require_once 'includes/session_helper.php';
$pageTitle = "RCE Lab Dashboard";
include 'includes/header.php';
?>

<div class="grid">
    <!-- Level 1 -->
    <div class="card low">
        <span class="badge badge-low">Level 1: Low</span>
        <h3>Classic Command Injection</h3>
        <p>A basic network diagnostic tool that fails to sanitize user input before passing it to the system shell. Start here.</p>
        <a href="level1.php" class="btn">Enter Lab</a>
    </div>

    <!-- Level 2 -->
    <div class="card low">
        <span class="badge badge-low">Level 2: Low</span>
        <h3>Command Concatenation</h3>
        <p>The developer added a check for the start of the command, but forgot about shell operators like &&, ||, and ;.</p>
        <a href="level2.php" class="btn">Enter Lab</a>
    </div>

    <!-- Level 3 -->
    <div class="card medium">
        <span class="badge badge-medium">Level 3: Medium</span>
        <h3>Character Blacklist</h3>
        <p>A simple WAF blocks semicolons and ampersands. Can you find another way to chain commands in Linux?</p>
        <a href="level3.php" class="btn">Enter Lab</a>
    </div>

    <!-- Level 4 -->
    <div class="card medium">
        <span class="badge badge-medium">Level 4: Medium</span>
        <h3>Restricted Shell Access</h3>
        <p>Spaces and slashes are strictly forbidden. You'll need to use shell variables and alternative delimiters to bypass this.</p>
        <a href="level4.php" class="btn">Enter Lab</a>
    </div>

    <!-- Level 5 -->
    <div class="card high">
        <span class="badge badge-high">Level 5: High</span>
        <h3>Dynamic Calculator</h3>
        <p>Input is evaluated as PHP code. Learn how to break out of a string context and execute system commands via eval().</p>
        <a href="level5.php" class="btn">Enter Lab</a>
    </div>

    <!-- Level 6 -->
    <div class="card high">
        <span class="badge badge-high">Level 6: High</span>
        <h3>Blind RCE</h3>
        <p>The command executes, but the output is never returned. Use time-based delays or OAST to confirm your success.</p>
        <a href="level6.php" class="btn">Enter Lab</a>
    </div>

    <!-- Level 7 -->
    <div class="card high">
        <span class="badge badge-high">Level 7: High</span>
        <h3>Insecure Deserialization</h3>
        <p>A configuration object is unsafely deserialized. Exploit the __destruct magic method to trigger command execution.</p>
        <a href="level7.php" class="btn">Enter Lab</a>
    </div>

    <!-- Level 8 -->
    <div class="card critical">
        <span class="badge badge-critical">Level 8: Expert</span>
        <h3>Server-Side Template Injection</h3>
        <p>A dynamic mailer uses a mock template engine. Can you find the interpolation syntax and escalate to RCE?</p>
        <a href="level8.php" class="btn">Enter Lab</a>
    </div>

    <!-- Level 9 -->
    <div class="card critical">
        <span class="badge badge-critical">Level 9: Expert</span>
        <h3>PHP Filter Chain</h3>
        <p>No file uploads? No problem. Use the power of php://filter to generate a webshell entirely in memory via an LFI.</p>
        <a href="level9.php" class="btn">Enter Lab</a>
    </div>

    <!-- Level 10 -->
    <div class="card elite">
        <span class="badge badge-elite">Level 10: Elite</span>
        <h3>Log Poisoning (Final Boss)</h3>
        <p>The ultimate challenge. Poison the server logs with PHP code and include them via a local file inclusion vulnerability.</p>
        <a href="level10.php" class="btn">Enter Lab</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
