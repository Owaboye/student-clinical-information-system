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
    $datetime = $_POST['appointment_date'];
    $reason = trim($_POST['reason']);

    $error = '';
    // Check for conflicts
    $conflict = $pdo->prepare("SELECT * FROM appointments 
                               WHERE staff_id = ? AND appointment_date = ? 
                               AND status IN ('Pending', 'Approved')");
    $conflict->execute([$staff_id, $datetime]);

    if(validateAppointmentDate($datetime)){
        $error = "Appointment date cannot be in the past.";
    }


    if ($conflict->rowCount() > 0) {
        $error = "Selected time is already booked.";
    } 

    if(empty($error)){
        $stmt = $pdo->prepare("INSERT INTO appointments (student_id, staff_id, appointment_date, reason) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user['id'], $staff_id, $datetime, $reason]);
        $success = "Appointment requested successfully.";
    }
}

// Fetch available staff (doctors/nurses)
$staff = $pdo->query("SELECT id, CONCAT(fname, ' ', lname) AS full_name FROM users 
                      WHERE role_id IN (SELECT id FROM roles WHERE name IN ('Doctor', 'Nurse'))")
             ->fetchAll(PDO::FETCH_ASSOC);

?>


