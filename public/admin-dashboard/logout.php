<?php require_once '../../config/functions.php'; ?>
<?php
// session_start();

// Unset all session variables
$_SESSION = [];

// Destroy session cookie
if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
  );
}



// Destroy session
session_destroy();

// Redirect to login
header("Location: ".baseUrl('index.php'));

exit;
