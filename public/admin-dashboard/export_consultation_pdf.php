<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'vendor/dompdf/autoload.inc.php'; ?>
<?php 

use Dompdf\Dompdf;

$id = $_GET['id'] ?? null;
if (!$id) exit("Missing ID");

// Fetch consultation
$stmt = $pdo->prepare("SELECT c.*, CONCAT(s.fname, ' ', s.lname) AS student, CONCAT(u.fname, ' ', u.lname) AS staff 
                       FROM consultations c 
                       JOIN users s ON c.student_id = s.id 
                       JOIN users u ON c.staff_id = u.id 
                       WHERE c.id = ?");
$stmt->execute([$id]);
$c = $stmt->fetch();

// Prescriptions
$stmt2 = $pdo->prepare("SELECT * FROM prescriptions WHERE consultation_id = ?");
$stmt2->execute([$id]);
$prescriptions = $stmt2->fetchAll();

// Lab results
$stmt3 = $pdo->prepare("SELECT * FROM lab_results WHERE consultation_id = ?");
$stmt3->execute([$id]);
$lab_results = $stmt3->fetchAll();

// HTML for PDF
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
  <style>
    body { font-family: DejaVu Sans, sans-serif; }
    h2, h4 { margin-bottom: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    table, th, td { border: 1px solid #999; padding: 6px; }
  </style>
</head>
<body>
  <h1>Crawford University</h1>
  <p>Address:</p>
<hr>
  <h2>Consultation Report</h2>
  <h4>Date: <?= date('Y-m-d H:i', strtotime($c['created_at'])) ?></h4>
  <p><strong>Student:</strong> <?= htmlspecialchars($c['student']) ?></p>
  <p><strong>Staff:</strong> <?= htmlspecialchars($c['staff']) ?></p>
  <p><strong>Diagnosis:</strong> <?= nl2br(htmlspecialchars($c['diagnosis'])) ?></p>
  <p><strong>Notes:</strong> <?= nl2br(htmlspecialchars($c['notes'])) ?></p>
<hr>
  <?php if ($prescriptions): ?>
    <h4>Prescriptions</h4>
    <table>
      <tr><th>Medication</th><th>Dosage</th><th>Frequency</th><th>Duration</th><th>Instructions</th></tr>
      <?php foreach ($prescriptions as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p['medication_name']) ?></td>
        <td><?= htmlspecialchars($p['dosage']) ?></td>
        <td><?= htmlspecialchars($p['frequency']) ?></td>
        <td><?= htmlspecialchars($p['duration']) ?></td>
        <td><?= htmlspecialchars($p['instructions']) ?></td>
      </tr>
      <?php endforeach ?>
    </table>
  <?php endif ?>
<hr>
  <?php if ($lab_results): ?>
    <h4>Lab Results</h4>
    <table>
      <tr><th>Title</th><th>Result</th></tr>
      <?php foreach ($lab_results as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['title']) ?></td>
        <td><?= nl2br(htmlspecialchars($r['result'])) ?></td>
      </tr>
      <?php endforeach ?>
    </table>
  <?php endif ?>
</body>
</html>
<?php
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("consultation_$id.pdf", ["Attachment" => false]);