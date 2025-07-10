<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php 

if ($user['role'] !== 'Student') {
        die("Access denied. Admins only.");
    } 
if (isset($_GET['delete_id'])) {
    $appointment_id = sanitizeAndValidateQueryString($_GET['delete_id']);
    // dd($appointment_id);

    // Delete appointment with ID 7 from `appointments` table
    if (delete_record('appointments', 'id', $appointment_id)) {
        set_flash_message('success', 'Record deleted successfully.');
        header('Location: student-appointments.php');
        exit;
    } else {
        set_flash_message('success', 'No record was deleted.');
        header('Location: student-appointments.php');
        exit;
    }
}else{
     header('Location: student-appointments.php');
     exit;
}
    

    
?>

