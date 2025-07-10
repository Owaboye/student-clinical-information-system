<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $fname = sanitizeStr($_POST['fname']);
    $lname = sanitizeStr($_POST['lname']);
    $email = sanitizeEmail($_POST['email']);
    $user_number = trim($_POST['user_number']);
    $dept = sanitizeStr($_POST['dept']);

    $fullName = $fname.$lname;

    $role_id = (int) $_POST['role_id'];

    $errors = [];

    // Validate Name
    if (!validateStr($fname)) {
        $errors['fname'] = "Empty or invalid first name format.";
    }

    if (!validateStr($lname)) {
        $errors['lname'] = "Empty or invalid last name format.";
    }

    if(empty($_POST['role_id'])){
        $errors['user_role'] = "Empty or invalid entry.";
    }

    // Validate Email
    if (!validateEmail($email)) {
        $errors['email'] = "Empty or invalid email address.";
    }

    if(!validateNumericInput($user_number)) {
        $errors['user_number'] = "Empty or invalid user number.";
    }

    if(usernameExit("users", "email", $email)){
        $errors['email'] = 'Email Already taken';
    }

    $username = generate_unique_username($pdo, $fullName, $table = 'users', $column = 'username');

    $password_hash = password_hash('crawford', PASSWORD_DEFAULT);
    // Validate
    if (empty($errors) ) {
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, role_id, email, fname, lname, dept, user_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $password_hash, $role_id, $email, $fname, $lname, $dept, $user_number]);
        // $success = 'User registered successfully!';
        set_flash_message('success', 'User registered successfully!');
         header('Location: user-index.php');
        exit;
    }
}

$roles = getAll('roles');
?>

