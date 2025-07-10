<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php 

$file_id = $_GET['id'] ?? null;
if (!$file_id) exit("Missing file ID");

// Fetch file info
$stmt = $pdo->prepare("SELECT * FROM consultation_files WHERE id = ?");
$stmt->execute([$file_id]);
$file = $stmt->fetch();

if (!$file) exit("File not found");

// Delete file from disk
if (file_exists($file['file_path'])) {
    unlink($file['file_path']);
}

// Delete from DB
$stmt = $pdo->prepare("DELETE FROM consultation_files WHERE id = ?");
$stmt->execute([$file_id]);

// Redirect back to consultation view
header("Location: view_consultation.php?id=" . $file['consultation_id']);
exit;

    
?>

