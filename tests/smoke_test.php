<?php
/**
 * RCE-Lab Static & Functional Verification Test Suite
 * Author: zoly
 */

echo "=== RCE-Lab Quality & Integrity Verification ===\n";

$files = [
    'index.php',
    'level1.php',
    'level2.php',
    'level3.php',
    'level4.php',
    'level5.php',
    'level6.php',
    'level7.php',
    'level8.php',
    'level9.php',
    'level10.php',
    'includes/header.php',
    'includes/footer.php',
    'includes/session_helper.php',
    'WIKI.md',
    'README.md',
    'wiki/RCE_Deep_Dive.md'
];

$passed = 0;
$failed = 0;

foreach ($files as $file) {
    if (file_exists($file) && is_readable($file)) {
        // Run syntax check if php file
        if (substr($file, -4) === '.php') {
            $output = [];
            $exitCode = 0;
            exec("php -l " . escapeshellarg($file), $output, $exitCode);
            if ($exitCode === 0) {
                echo "[PASS] $file (Syntax OK)\n";
                $passed++;
            } else {
                echo "[FAIL] $file (Syntax Error)\n";
                $failed++;
            }
        } else {
            echo "[PASS] $file (Exists & Readable)\n";
            $passed++;
        }
    } else {
        echo "[FAIL] $file (Missing or unreadable)\n";
        $failed++;
    }
}

echo "===============================================\n";
echo "Results: $passed Passed, $failed Failed\n";

if ($failed > 0) {
    exit(1);
} else {
    exit(0);
}
?>
