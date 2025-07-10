<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php 

        // Allow only Doctor or Nurse
        if (!in_array($_SESSION['user']['role'], ['Doctor', 'Nurse', 'Admin'])) {
            die("Access denied.");
        }

        $user_id = $_SESSION['user']['id'];
        $user =  usernameExit("users", "id", $user_id);

        $role = $_GET['role'] ?? '';
        $user_number = $_GET['user_number'] ?? '';
        $email = $_GET['email'] ?? '';

        if($role || $user_number || $email){
            $where = [];
            $params = [];

            if (!empty($role)) {
                $where[] = "role_id >= :role_id";
                $params[':role_id'] = $role;
            }

            if (!empty($user_number)) {
                $where[] = "user_number = :user_number";
                $params[':to'] = $user_number;
            }

            if (!empty($status)) {
                $where[] = "status = :status";
                $params[':status'] = $status;
            }

            $sql = "SELECT a.*, CONCAT(s.fname, ' ', s.lname) AS student, CONCAT(d.fname, ' ', d.lname) AS staff 
                    FROM appointments a
                    JOIN users s ON a.student_id = s.id
                    JOIN users d ON a.staff_id = d.id";

            if ($where) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }

            $sql .= " ORDER BY appointment_date DESC";

            // dd($sql);

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $stmt = $pdo->prepare("SELECT a.*, CONCAT(s.fname, ' ', s.lname) AS student, CONCAT(d.fname, ' ', d.lname) AS staff 
                       FROM appointments a
                       JOIN users s ON a.student_id = s.id
                       JOIN users d ON a.staff_id = d.id
                       ORDER BY appointment_date DESC");
            $stmt->execute();
            $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $status = '';
        }
        


?>
    

    

    

    


