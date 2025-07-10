<?php
function baseUrl($path = '') {
    // Detect HTTPS
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || 
                 $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    // Host
    $host = $_SERVER['HTTP_HOST'];

    // Base directory (optional, useful if your app is in a subfolder)
    // $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    // $scriptName = __DIR__;

    // Remove trailing slash if present
    // $scriptName = rtrim($scriptName, '/');
    $dirname = 'cdms/';

    // Combine
    return $protocol . $host  . '/' .$dirname. ltrim($path, '/');
}

// Usage examples
// echo baseUrl();                      // https://example.com or https://example.com/myapp
// echo baseUrl('user/profile/23');     // https://example.com/user/profile/23
// echo baseUrl('dashboard');           // https://example.com/dashboard


 ?>