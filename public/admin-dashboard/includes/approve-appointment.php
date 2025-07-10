<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php 

// Allow only Student
    if ($user['role'] !== 'Doctor') {
        die("Access denied. Doctor or Nurse only.");
    } 

                                                    

?>
    

    

    

    


