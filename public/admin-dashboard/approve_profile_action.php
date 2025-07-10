<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/filter-schedule.php'; ?>
<?php require_once 'vendor/dompdf/autoload.inc.php'; ?>

<?php use Dompdf\Dompdf; ?>

<?php require_once 'includes/header.php'; ?>
<?php 
        // Allow only Doctor or Nurse
    // if (!in_array($_SESSION['user']['role'], ['Doctor', 'Nurse'])) {
    //     die("Access denied.");
    // }
    if (!isStaff()) die("Access denied.");

    $id = $_POST['id'] ?? null;
    $action = $_POST['action'] ?? '';

    if (!$id || !in_array($action, ['approve', 'reject'])) {
        exit("Invalid input.");
    }

    $status = ($action === 'approve') ? 'approved' : 'rejected';
    $staff_id = $_SESSION['user']['id'];

    $stmt = $pdo->prepare("
      UPDATE student_profiles 
      SET approved = ?, approved_by = ?, approved_at = NOW() 
      WHERE id = ?
    ");
    $stmt->execute([$status, $staff_id, $id]);

    header("Location: pending_profiles.php");
    exit;

 ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once 'includes/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require_once 'includes/top-bar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    
                   
                   
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
           <?php include 'includes/copy-right.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

<?php require_once 'includes/footer.php'; ?>