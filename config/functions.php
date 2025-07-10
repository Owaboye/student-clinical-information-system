<?php
session_start();
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

function getAll($table, $limit=10){
    global $pdo;
    $sql = "SELECT * FROM ".$table ." LIMIT ".$limit;
    $stmt = $pdo->prepare($sql);

    // Execute
    $stmt->execute();

    // Fetch result (as associative array)
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function set_flash_message($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function display_flash_message() {
    if (isset($_SESSION['flash'])) {
        $type = $_SESSION['flash']['type'];
        $message = $_SESSION['flash']['message'];

        // Example Bootstrap alert style
        echo "<div class='alert alert-{$type}' role='alert'>{$message}</div>";

        // Unset the message after displaying it
        unset($_SESSION['flash']);
    }
}

function validateAndSanitizeInput($name, $email, $password) {
    $errors = [];

    // --- Name Validation ---
    $name = trim($name);
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($name) || !preg_match("/^[a-zA-Z\s'-]+$/", $name)) {
        $errors[] = "Name must contain only letters, spaces, hyphens, and apostrophes.";
    }

    // --- Email Validation ---
    $email = trim($email);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // --- Password Validation (strong policy) ---
    $password = trim($password);

    $passwordPolicy = [
        'minLength' => 8,
        'uppercase' => '/[A-Z]/',
        'lowercase' => '/[a-z]/',
        'number'    => '/[0-9]/',
        'special'   => '/[\W_]/'
    ];

    if (strlen($password) < $passwordPolicy['minLength']) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if (!preg_match($passwordPolicy['uppercase'], $password)) {
        $errors[] = "Password must include at least one uppercase letter.";
    }
    if (!preg_match($passwordPolicy['lowercase'], $password)) {
        $errors[] = "Password must include at least one lowercase letter.";
    }
    if (!preg_match($passwordPolicy['number'], $password)) {
        $errors[] = "Password must include at least one number.";
    }
    if (!preg_match($passwordPolicy['special'], $password)) {
        $errors[] = "Password must include at least one special character.";
    }

    return [
        'valid' => empty($errors),
        'errors' => $errors,
        'sanitized' => [
            'name' => $name,
            'email' => $email,
            'password' => $password  // You can hash it before storing
        ]
    ];
}

function validateNumericInput($input) {
    // Trim whitespace
    $input = trim($input);

    // Check if it matches the pattern (digits and optional hyphens)
    if (preg_match('/^[0-9]+(-[0-9]+)*$/', $input)) {
        return $input; // Valid input
    } else {
        return false; // Invalid input
    }
}


function sanitizeStr($name) {
    return filter_var(trim($name), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

function validateStr($name) {
    if(empty($name) || !preg_match("/^[a-zA-Z\s'-]+$/", $name)){
        return false;
    }

    return true;
}

function sanitizeEmail($email) {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

function validateEmail($email) {
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        return false;
    }
    return true;
}

function validateNum($data){
    if(empty($data) || !preg_match("/(\d+)/", $data)){
        return false;
    }
    return true;
}

function usernameExit($table, $column, $value){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE $column = ?");
    $stmt->execute([$value]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        return $result;
    } 
}

function findBy($table, $column, $value){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE $column = ?");
    $stmt->execute([$value]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
        return $result;
    } 
}


function validatePassword($password) {
    $errors = [];

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must include at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must include at least one lowercase letter.";
    }
    if (!preg_match('/\d/', $password)) {
        $errors[] = "Password must include at least one number.";
    }
    if (!preg_match('/[\W_]/', $password)) {
        $errors[] = "Password must include at least one special character.";
    }

    return $errors;
}

function handleImageUpload($file, $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'], $maxSizeMB = 2) {
    $errors = [];

    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "No file uploaded or upload error.";
        return [false, $errors];
    }

    if (!in_array($file['type'], $allowedTypes)) {
        $errors[] = "Only JPG, PNG, and GIF files are allowed.";
    }

    $maxSizeBytes = $maxSizeMB * 1024 * 1024;
    if ($file['size'] > $maxSizeBytes) {
        $errors[] = "File size must not exceed {$maxSizeMB}MB.";
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFilename = uniqid('img_', true) . '.' . $extension;
    $uploadDir = 'uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $destination = $uploadDir . $newFilename;

    if (empty($errors)) {
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return [$destination, []];
        } else {
            $errors[] = "Failed to move uploaded file.";
        }
    }

    return [false, $errors];
}

function dd($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    exit();
}

function sanitizeAndValidateQueryString($queryString) {
    // Remove unwanted characters
    $sanitized = filter_var($queryString, FILTER_SANITIZE_URL);

    // Validate format (only alphanumeric, hyphens, and ampersands)
    if (preg_match('/^[a-zA-Z0-9&=-]+$/', $sanitized)) {
        return $sanitized; // Valid query string
    } else {
        return false; // Invalid query string
    }
}

// Database function
function delete_record(string $table, string $column, $value): bool {
    global $pdo;
    try {
        // Build the SQL DELETE query with a placeholder
        $sql = "DELETE FROM `$table` WHERE `$column` = :value";
        $stmt = $pdo->prepare($sql);

        // Bind the value with automatic type detection
        $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
        $stmt->bindValue(':value', $value, $paramType);

        // Execute and return status
        return $stmt->execute();
    } catch (PDOException $e) {
        // Optional: Log the error or handle it differently
        error_log("PDO DELETE ERROR: " . $e->getMessage());
        return false;
    }
}


function generate_unique_username(PDO $pdo, string $fullName, string $table = 'users', string $column = 'username'): string {
    // Normalize name: e.g. "John Doe" → "johndoe"
    $baseUsername = strtolower(preg_replace('/\s+/', '', $fullName));
    $username = $baseUsername;
    $counter = 1;

    // Check for uniqueness and increment if needed
    while (username_exists($pdo, $username, $table, $column)) {
        $username = $baseUsername . $counter;
        $counter++;
    }

    return $username;
}

function username_exists(PDO $pdo, string $username, string $table, string $column): bool {
    $sql = "SELECT COUNT(*) FROM `$table` WHERE `$column` = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);
    return $stmt->fetchColumn() > 0;
}

function validateAppointmentDate($date){
    $datetime = $date;
    $currentDateTime = date('Y-m-d H:i:s');

    if (strtotime($datetime) < strtotime($currentDateTime)) {
        return true;
    }
}

function isStaff() {
  return isset($_SESSION['user']['role']) && in_array($_SESSION['user']['role'], ['Admin', 'Doctor', 'Nurse']);
}

function isLoggedIn() {
  return isset($_SESSION['user']['role']) && in_array($_SESSION['user']['role'], ['Admin', 'Doctor', 'Nurse', 'Student']);
}

function isStudent() {
  return isset($_SESSION['user']['role']) && ($_SESSION['user']['role'] == 'Student');
}

function isAdmin() {
  return isset($_SESSION['user']['role']) && ($_SESSION['user']['role'] == 'Admin');
}
