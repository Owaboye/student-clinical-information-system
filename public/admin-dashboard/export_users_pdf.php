<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'vendor/dompdf/autoload.inc.php'; ?>
<?php 

use Dompdf\Dompdf;

            $where = [];
            $params = [];

            if (!empty($_GET['start_date'])) {
                $where[] = "created_at >= :from";
                $params[':from'] = $_GET['start_date'];
            }

            if (!empty($_GET['role'])) {
                $where[] = "role_id = :role";
                $params[':role'] = $_GET['role'];
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

// Generate HTML for PDF
ob_start();

?>
<h2>Users</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
  <thead>
     <tr>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>
        
    </tr>
  </thead>
  <tbody>
    <?php foreach($users as $user): ?>
          <?php 

          $role = usernameExit('roles', 'id', $user['role_id']);

           ?>
      <tr>
          <td><?php echo $user['user_number'] ?? '' ?></td>
          <td><?php echo $user['fname'] ?? '' ?></td>
          <td><?php echo $user['lname'] ?? '' ?></td>
          <td><?php echo $user['email'] ?? '' ?></td>

          <td><?php echo $role['name'] ?? '' ?></td>
          
  
      </tr>
  <?php endforeach ?>
  </tbody>
</table>
<?php
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("users.pdf", ["Attachment" => true]);
exit;