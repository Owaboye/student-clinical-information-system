<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php

$appointment_id = $_POST['appointment_id'];
$student_id = $_POST['student_id'];
$staff_id = $_SESSION['user']['id'];
$diagnosis = sanitizeStr($_POST['diagnosis']);
$notes = sanitizeStr($_POST['notes']);
$prescriptions = $_POST['prescriptions'] ?? [];

try {
  $pdo->beginTransaction();

  // Save consultation
  $stmt = $pdo->prepare("INSERT INTO consultations 
    (appointment_id, staff_id, student_id, diagnosis, notes) 
    VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$appointment_id, $staff_id, $student_id, $diagnosis, $notes]);

  $consultation_id = $pdo->lastInsertId();

  // Save prescriptions
  if (!empty($prescriptions)) {
    $stmt2 = $pdo->prepare("INSERT INTO prescriptions 
      (consultation_id, medication_name, dosage, frequency, duration, instructions) 
      VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($prescriptions as $p) {
      $stmt2->execute([
        $consultation_id,
        $p['medication_name'],
        $p['dosage'],
        $p['frequency'],
        $p['duration'],
        $p['instructions']
      ]);
    }
  }

  // Save Lab result
  $lab_results = $_POST['lab_results'] ?? [];

if (!empty($lab_results)) {
    $stmt3 = $pdo->prepare("INSERT INTO lab_results (consultation_id, title, result) VALUES (?, ?, ?)");
    foreach ($lab_results as $r) {
        $stmt3->execute([$consultation_id, $r['title'], $r['result']]);
    }
}


// Consultation file
$upload_dir = 'uploads/consultation_files/';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

if (!empty($_FILES['attachments']['name'][0])) {
    foreach ($_FILES['attachments']['tmp_name'] as $index => $tmpPath) {
        $originalName = basename($_FILES['attachments']['name'][$index]);
        $size = $_FILES['attachments']['size'][$index];
        $type = $_FILES['attachments']['type'][$index];

        // Basic validation
        if ($size > 2 * 1024 * 1024) continue; // Skip >2MB
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $allowed = ['pdf', 'jpg', 'jpeg', 'png', 'docx'];
        if (!in_array(strtolower($ext), $allowed)) continue;

        $newName = uniqid() . "_" . preg_replace("/[^a-zA-Z0-9_\.-]/", "_", $originalName);
        $targetPath = $upload_dir . $newName;

        if (move_uploaded_file($tmpPath, $targetPath)) {
            $stmt = $pdo->prepare("INSERT INTO consultation_files (consultation_id, file_name, file_path) VALUES (?, ?, ?)");
            $stmt->execute([$consultation_id, $originalName, $targetPath]);
        }
    }
}


  $pdo->commit();

  set_flash_message('success', 'Record saved successfully');

  header("Location: ".baseUrl('public/admin-dashboard/consultations_list.php?success=1'));
  exit;

} catch (Exception $e) {
  $pdo->rollBack();
  die("Error: " . $e->getMessage());
}
