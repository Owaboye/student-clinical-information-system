<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php 

if ($user['role'] !== 'Admin') {
        die("Access denied. Admins only.");
    } 
if (isset($_GET['delete_id'])) {
    $user_id = sanitizeAndValidateQueryString($_GET['delete_id']);
    // dd($user_id);

    // Delete user with ID 7 from `users` table
    if (delete_record('users', 'id', $user_id)) {
        set_flash_message('success', 'Record deleted successfully.');
        header('Location: user-index.php');
        exit;
    } else {
        set_flash_message('success', 'No record was deleted.');
        header('Location: user-index.php');
        exit;
    }
}else{
     header('Location: user-index.php');
     exit;
}
    

    
?>

