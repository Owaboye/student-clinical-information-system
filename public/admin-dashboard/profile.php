<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/filter-schedule.php'; ?>
<?php require_once 'includes/header.php'; ?>
<?php 
        // Allow only Doctor or Nurse
    if (!in_array($_SESSION['user']['role'], ['Doctor', 'Nurse'])) {
        die("Access denied.");
    } 

 $user_id = $_GET['id'];

// Profile Info
$stmt1 = $pdo->prepare("SELECT * FROM student_profiles WHERE user_id = ?");
$stmt1->execute([$user_id]);
$profile = $stmt1->fetch();

$stmt = $pdo->prepare("
        SELECT u.*, concat(u.fname, ' ', u.lname) as full_name, sp.blood_type, sp.genotype,sp.approved
        FROM users u
        LEFT JOIN student_profiles sp ON sp.user_id = u.id
        WHERE u.id  = ?
        ");
 $stmt->execute([$user_id]);
 $profile = $stmt->fetch(); 

 // dd($profile);

// Last Consultation
$stmt2 = $pdo->prepare("
  SELECT * FROM consultations 
  WHERE student_id = ? 
  ORDER BY created_at DESC LIMIT 1
");
$stmt2->execute([$user_id]);
$last_visit = $stmt2->fetch();

// Last Prescriptions
$prescriptions = [];
if ($last_visit) {
  $stmt3 = $pdo->prepare("SELECT * FROM prescriptions WHERE consultation_id = ?");
  $stmt3->execute([$last_visit['id']]);
  $prescriptions = $stmt3->fetchAll();
}

// Last Lab Results
$lab_results = [];
if ($last_visit) {
  $stmt4 = $pdo->prepare("SELECT * FROM lab_results WHERE consultation_id = ?");
  $stmt4->execute([$last_visit['id']]);
  $lab_results = $stmt4->fetchAll();
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
                    <?php if (in_array($_SESSION['user']['role'], ['Doctor', 'Nurse'])) { ?>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-10 mb-4 mx-auto">
                             
                            <?php display_flash_message(); ?>
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                     <h3 class="m-0 font-weight-bold text-primary">Student Profile </h3> 
                                </div>
                                
                                <div class="card-body">
                               
                                <?php if (!empty($profile)): ?>
                                 <p>
                                     <strong>Full Name:</strong> <?= $profile['full_name']  ?>
                                 </p>
                                 <p>
                                     <strong>Matric Number:</strong> <?= $profile['user_number']  ?>
                                 </p>
                                  <p><strong>Blood Type:</strong> <?= $profile['blood_type'] ?? 'N/A' ?></p>
                                    <p><strong>Genotype:</strong> <?= $profile['genotype'] ?? 'N/A' ?></p>
                                    <p><strong>Allergies:</strong> <?= nl2br($profile['allergies'] ?? '-') ?></p>
                                    <p><strong>Chronic Conditions:</strong> <?= nl2br($profile['chronic_conditions'] ?? '-') ?></p>
                                    <p><strong>Status:</strong>
                                      <?php
                                        if (!$profile['approved']) echo "<span class='text-danger'>Not Set</span>";
                                        elseif ($profile['approved'] === 'approved') echo "<span class='text-success'>Approved</span>";
                                        elseif ($profile['approved'] === 'pending') echo "<span class='text-warning'>Pending</span>";
                                        else echo "<span class='text-danger'>Rejected</span>";
                                      ?>
                                    </p>
                                   
                                 
                                <?php endif ?>   
                                       
                                </div>
                                
                                    
                                </div>

                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Last Clinic Visit</h6>
                                    </div>
                               
                                    <div class="card-body">

                                        <?php if ($last_visit): ?>
                                          <p><strong>Date:</strong> <?= date('d M Y, h:i A', strtotime($last_visit['created_at'])) ?></p>
                                          <p><strong>Diagnosis:</strong> <?= nl2br($last_visit['diagnosis']) ?></p>
                                          <p><strong>Notes:</strong> <?= nl2br($last_visit['notes']) ?></p>

                                          <?php if ($prescriptions): ?>
                                            <h6>Medications Prescribed:</h6>
                                            <ul>
                                              <?php foreach ($prescriptions as $p): ?>
                                                <li><?= htmlspecialchars($p['medication_name']) ?> — <?= htmlspecialchars($p['dosage']) ?> for <?= htmlspecialchars($p['duration']) ?></li>
                                              <?php endforeach ?>
                                            </ul>
                                          <?php endif ?>

                                          <?php if ($lab_results): ?>
                                            <h6>Lab Results:</h6>
                                            <ul>
                                              <?php foreach ($lab_results as $r): ?>
                                                <li><strong><?= htmlspecialchars($r['title']) ?>:</strong> <?= nl2br($r['result']) ?></li>
                                              <?php endforeach ?>
                                            </ul>
                                          <?php endif ?>

                                        <?php else: ?>
                                          <p class="text-muted">You haven't visited the clinic yet.</p>
                                        <?php endif ?>
                                        
                                        
                                    </div>
                                </div>
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
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

<?php require_once 'includes/footer.php'; ?>