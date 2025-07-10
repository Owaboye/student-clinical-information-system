<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/header.php'; ?>

<?php 

// dd($user['id']);
if ($_POST['approveBtn']) {
    
    $id = $_POST['appointment_id'];
    $status = $_POST['status'];

    if($status){
        $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE id = ? AND staff_id = ?");
        $stmt->execute([$status, $id, $user['id']]);
        set_flash_message('success', 'Status changed successfully!');
        header("Location: ".baseUrl('public/admin-dashboard/my_schedule.php'));
        exit();
    }else{
        set_flash_message('danger', 'Please, select a status');
        header("Location: ".baseUrl('public/admin-dashboard/index.php'));
        exit();
    }

    
}


 ?>