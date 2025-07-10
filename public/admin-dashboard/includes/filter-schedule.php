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
        $status = $_GET['status'] ?? '';
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';

    if(!empty($_GET['status'])){
        
        
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $where = "WHERE staff_id = ?";
        $params = [$user['id']];

        if ($status) {
            $where .= " AND a.status = ?";
            $params[] = $status;
        }

        if ($startDate) {
            $where .= " AND DATE(appointment_date) >= ?";
            $params[] = $startDate;
        }

        if ($endDate) {
            $where .= " AND DATE(appointment_date) <= ?";
            $params[] = $endDate;
        } 

        // Count for pagination
        $sql_query = "SELECT COUNT(*) FROM appointments a $where";

        $countStmt = $pdo->prepare($sql_query);
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();
        $totalPages = ceil($total / $limit);

        if(!empty($startDate) && !empty($endDate)){
            if (strtotime($startDate) > strtotime($endDate)) {
                $result = "The start date cannot be greater than end date.";
                $stmt = $pdo->prepare("SELECT a.*, CONCAT(u.fname, ' ', u.lname) AS student_name FROM appointments a
                JOIN users u ON a.student_id = u.id
                WHERE staff_id = ?
                ORDER BY appointment_date ASC");

                $stmt->execute([$user['id']]);
                $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }else{

            if($total){
                $sql = "SELECT a.*, concat(u.fname, ' ', u.lname) AS student_name FROM appointments a
                    JOIN users u ON a.student_id = u.id
                    $where
                    ORDER BY appointment_date ASC
                    LIMIT $limit OFFSET $offset";

                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result = "$total record(s) found";
                
            }else{
                $result = "No record match your search";
                $stmt = $pdo->prepare("SELECT a.*, CONCAT(u.fname, ' ', u.lname) AS student_name FROM appointments a
                JOIN users u ON a.student_id = u.id
                WHERE staff_id = ?
                ORDER BY appointment_date ASC");

                $stmt->execute([$user['id']]);
                $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }

           

    }else{
        
    $stmt = $pdo->prepare("SELECT a.*, CONCAT(u.fname, ' ', u.lname) AS student_name FROM appointments a
    JOIN users u ON a.student_id = u.id
    WHERE staff_id = ?
    ORDER BY appointment_date ASC");

    $stmt->execute([$user['id']]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

?>
    

    

    

    


