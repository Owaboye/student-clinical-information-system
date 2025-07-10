<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php 

        $user_id = $_SESSION['user']['id'];
        $user =  usernameExit("users", "id", $user_id);

        $status = $_GET['role'] ?? '';
        $startDate = $_GET['start_date'] ?? '';

        if($status || $startDate){
            
            $where = [];
            $params = [];

            if (!empty($startDate)) {
                $where[] = "created_at >= :from";
                $params[':from'] = $startDate;
            }

            if (!empty($status)) {
                $where[] = "role_id = :role";
                $params[':role'] = $status;
            }

            $sql = "SELECT 
                        u.*,
                        r.name
                    FROM roles r
                    JOIN users u ON u.role_id = r.id";

            if ($where) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }

            $sql .= " ORDER BY created_at DESC";

            // dd($sql);

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // dd($users);
             $roles = getAll('roles');
        }else{
            $users = getAll('users');
            $roles = getAll('roles');
            
            $status = '';
        }
        


?>
    

    

    

    


