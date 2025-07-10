<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/filter-schedule.php'; ?>
<?php require_once 'vendor/dompdf/autoload.inc.php'; ?>

<?php use Dompdf\Dompdf; ?>

<?php require_once 'includes/header.php'; ?>
<?php 
        // Allow only Doctor or Nurse
    if (!in_array($_SESSION['user']['role'], ['Doctor', 'Nurse', 'Admin'])) {
        die("Access denied.");
    }

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
                    <?php //require_once 'includes/page-header.php' ?>
                   
                    <!-- Doctor Area -->
                    <?php if (in_array($_SESSION['user']['role'], ['Doctor', 'Nurse', 'Admin']) ) { ?>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-10 mb-4 mx-auto">
                             <?php 
                                if (!empty($result)) echo "<div class='alert alert-danger'>$result</div>"; 
                             ?>
                            <?php display_flash_message(); 

                                $id = $_GET['id'] ?? null;
                                if (!$id) exit("Missing profile ID");

                                // Get the profile
                                $stmt = $pdo->prepare("
                                  SELECT sp.*, concat(u.fname, ' ', u.lname) as full_name, u.user_number
                                  FROM student_profiles sp
                                  JOIN users u ON sp.user_id = u.id
                                  WHERE sp.id = ? 
                                ");
                                $stmt->execute([$id]);
                                $p = $stmt->fetch();

                                if (!$p) exit("Profile not found.");
                            ?>
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Review Student Profile</h6>

                                    
                                </div>
                                
                                <div class="card-body">
                                    <h3>Review Profile: <?= htmlspecialchars($p['full_name']) ?> (<?= htmlspecialchars($p['user_number']) ?>)</h3>

                                        <ul class="list-group">
                                          <li class="list-group-item"><strong>Blood Type:</strong> <?= htmlspecialchars($p['blood_type']) ?></li>
                                          <li class="list-group-item"><strong>Genotype:</strong> <?= htmlspecialchars($p['genotype']) ?></li>
                                          <li class="list-group-item"><strong>Allergies:</strong><br><?= nl2br(htmlspecialchars($p['allergies'])) ?></li>
                                          <li class="list-group-item"><strong>Chronic Conditions:</strong><br><?= nl2br(htmlspecialchars($p['chronic_conditions'])) ?></li>
                                          <li class="list-group-item"><strong>Emergency Contact:</strong><br><?= htmlspecialchars($p['emergency_contact_name']) ?> (<?= htmlspecialchars($p['emergency_contact_phone']) ?>)</li>
                                        </ul>

                                        <form method="post" action="approve_profile_action.php" class="mt-3">
                                          <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                          <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
                                          <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                                          <a href="pending_profiles.php" class="btn btn-secondary">Back</a>
                                        </form>
                                
                                
                                    
                                </div>
                            </div>

                            <!-- Color System -->
                           

                        </div>

                        
                    </div>
                    <?php } ?>

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