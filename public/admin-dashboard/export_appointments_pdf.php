<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'vendor/dompdf/autoload.inc.php'; ?>
<?php 

use Dompdf\Dompdf;

// $stmt = $pdo->prepare("SELECT a.*, CONCAT(s.fname, ' ', s.lname) AS student, CONCAT(d.fname, ' ', d.lname) AS staff 
//                        FROM appointments a
//                        JOIN users s ON a.student_id = s.id
//                        JOIN users d ON a.staff_id = d.id
//                        ORDER BY appointment_date DESC");
// $stmt->execute();
// $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$where = [];
$params = [];

if (!empty($_GET['start_date'])) {
    $where[] = "appointment_date >= :from";
    $params[':from'] = $_GET['start_date'];
}

if (!empty($_GET['end_date'])) {
    $where[] = "appointment_date <= :to";
    $params[':to'] = $_GET['end_date'] ;
}

if (!empty($_GET['status'])) {
    $where[] = "status = :status";
    $params[':status'] = $_GET['status'];
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

// Generate HTML for PDF
ob_start();

?>
<h2>Appointment Requests</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
  <thead>
    <tr><th>Student</th><th>Staff</th><th>Date</th><th>Status</th><th>Reason</th></tr>
  </thead>
  <tbody>
    <?php foreach ($appointments as $a): ?>
    <tr>
      <td><?= htmlspecialchars($a['student']) ?></td>
      <td><?= htmlspecialchars($a['staff']) ?></td>
      <td><?= date('Y-m-d H:i', strtotime($a['appointment_date'])) ?></td>
      <td><?= $a['status'] ?></td>
      <td><?= htmlspecialchars($a['reason']) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("appointments.pdf", ["Attachment" => true]);
exit;