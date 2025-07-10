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
    $user_id = sanitizeStr($_POST['user_id']);

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

    // Validate
    if (empty($errors) ) {
        $query = "UPDATE users SET role_id = ?, email = ?, fname = ?, lname = ?, dept = ?, user_number = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$role_id, $email, $fname, $lname, $dept, $user_number, $user_id]);
        
        set_flash_message('success', 'User record updated successfully!');

        header('Location: user-index.php');
        exit;
    }
}

$roles = getAll('roles');
?>

