<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php 

    
    $user_id = $_SESSION['user']['id'];

$data = [
  $_POST['blood_type'],
  $_POST['genotype'],
  $_POST['allergies'],
  $_POST['chronic_conditions'],
  $_POST['emergency_contact_name'],
  $_POST['emergency_contact_phone'],
  $user_id
];

// Check if record exists
$stmt = $pdo->prepare("SELECT id FROM student_profiles WHERE user_id = ?");
$stmt->execute([$user_id]);
$exists = $stmt->fetch();

if ($exists) {
  // Update
  $stmt = $pdo->prepare("UPDATE student_profiles SET 
      blood_type = ?, genotype = ?, allergies = ?, chronic_conditions = ?, 
      emergency_contact_name = ?, emergency_contact_phone = ? 
      WHERE user_id = ?");
  $stmt->execute($data);
} else {
  // Insert
  $stmt = $pdo->prepare("INSERT INTO student_profiles 
    (blood_type, genotype, allergies, chronic_conditions, emergency_contact_name, emergency_contact_phone, user_id)
    VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->execute($data);
}

header("Location: index.php");
exit;
?>

