<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php 

// Allow only Student
    if ($user['role'] !== 'Student') {
        die("Access denied. Student only.");
    } 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff_id = (int) $_POST['staff_id'];
    $datetime = sanitizeStr($_POST['appointment_date']);
    $db_date = sanitizeStr($_POST['db_date']);
    $reason = trim($_POST['reason']);
    $appointment_db_id = sanitizeStr($_POST['appointment_db_id']);

    // Check for conflicts
    $form_date_time = new Datetime($datetime);
    $db_date_time = new Datetime($db_date);

    if($form_date_time != $db_date_time){
        $conflict = $pdo->prepare("SELECT * FROM appointments 
                               WHERE staff_id = ? AND appointment_date = ? 
                               AND status IN ('Pending', 'Approved')");
        $conflict->execute([$staff_id, $datetime]);
        $datetime_db = $datetime;

        if ($conflict->rowCount() > 0) {
            $error = "Selected time is already booked.";
        } else {
            $stmt = $pdo->prepare("UPDATE appointments SET student_id = ?, staff_id = ?, appointment_date = ?, reason = ? WHERE id = ?"); 
            $stmt->execute([$user['id'], $staff_id, $datetime_db, $reason, $appointment_db_id]);
            set_flash_message('success', 'Appointment updated successfully.');
            header('Location: student-appointments.php');
            exit;
            // $success = "Appointment updated successfully.";
        }
        // dd('Date not equal');
    }else{
        $datetime_db = $db_date;
        $stmt = $pdo->prepare("UPDATE appointments SET student_id = ?, staff_id = ?, appointment_date = ?, reason = ? WHERE id = ?"); 
                                   
            $stmt->execute([$user['id'], $staff_id, $datetime_db, $reason, $appointment_db_id]);
        set_flash_message('success', 'Appointment updated successfully.');
        header('Location: student-appointments.php');
        exit;
    }
    

    
}

// Fetch available staff (doctors/nurses)
$staff = $pdo->query("SELECT id, CONCAT(fname, ' ', lname) AS full_name FROM users 
                      WHERE role_id IN (SELECT id FROM roles WHERE name IN ('Doctor', 'Nurse'))")
             ->fetchAll(PDO::FETCH_ASSOC);

?>
?>

