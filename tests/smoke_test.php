<?php
/**
 * RCE-Lab Automated Smoke Test Suite
 * Author: zoly
 */

$baseUrl = "http://localhost:8080";
$pages = [
    '/',
    '/level1.php',
    '/level2.php',
    '/level3.php',
    '/level4.php',
    '/level5.php',
    '/level6.php',
    '/level7.php',
    '/level8.php',
    '/level9.php',
    '/level10.php'
];

echo "=== RCE-Lab Smoke Test Suite ===\n";
$passed = 0;
$failed = 0;

foreach ($pages as $page) {
    $url = $baseUrl . $page;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        echo "[PASS] $page returned HTTP 200\n";
        $passed++;
    } else {
        echo "[FAIL] $page returned HTTP $httpCode\n";
        $failed++;
    }
}

echo "==============================\n";
echo "Results: $passed Passed, $failed Failed\n";

if ($failed > 0) {
    exit(1);
} else {
    exit(0);
}
?>
