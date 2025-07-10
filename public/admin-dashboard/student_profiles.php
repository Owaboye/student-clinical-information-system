<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/create-student-appointment.php'; ?>
<?php require_once 'includes/header.php'; ?>
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
                   <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-10 col-sm-10 mx-auto">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">My Profile </h6>
                                    <!-- <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="<?= baseUrl('public/admin-dashboard/appointment-index.php') ?>">View User</a>
                                            <a class="dropdown-item" href="<?= baseUrl('public/admin-dashboard/user-profile.php') ?>">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div> -->
                                </div>
                                <!-- Card Body -->
                                 <div class="card-body">
                                    <?php 
 $user_id = $_SESSION['user']['id'];

// Profile Info
$stmt1 = $pdo->prepare("SELECT * FROM student_profiles WHERE user_id = ?");
$stmt1->execute([$user_id]);
$profile = $stmt1->fetch();

// Last Consultation
$stmt2 = $pdo->prepare("
  SELECT * FROM consultations 
  WHERE student_id = ? 
  ORDER BY created_at DESC LIMIT 1
");
$stmt2->execute([$user_id]);
$last_visit = $stmt2->fetch();

// Staff Consultation
$Staff = $pdo->prepare("
  SELECT * FROM users 
  WHERE id = ? 
  LIMIT 1
");
$Staff->execute([$last_visit['staff_id']]);
$Staff_result = $Staff->fetch();

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
                                <p><strong>Blood Type:</strong> <?= $profile['blood_type'] ?? 'N/A' ?></p>
                                    <p><strong>Genotype:</strong> <?= $profile['genotype'] ?? 'N/A' ?></p>
                                    <p><strong>Allergies:</strong> <?= nl2br($profile['allergies'] ?? '-') ?></p>
                                    <p><strong>Chronic Conditions:</strong> <?= nl2br($profile['chronic_conditions'] ?? '-') ?></p>
                                    <p><strong>Status:</strong>
                                      <?php
                                        if (!$profile) echo "<span class='text-danger'>Not Set</span>";
                                        elseif ($profile['approved'] === 'approved') echo "<span class='text-success'>Approved</span>";
                                        elseif ($profile['approved'] === 'pending') echo "<span class='text-warning'>Pending</span>";
                                        else echo "<span class='text-danger'>Rejected</span>";
                                      ?>
                                    </p>
                                    <a href="edit_profile.php" class="btn btn-sm btn-outline-primary">Edit Profile</a>
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Last Clinic Visit</h6>
                                </div>
                               
                                <div class="card-body">

                                    <?php if ($last_visit): ?>

                                        <?php 

                                            if ($last_visit['updated_at'] != null) {
                                                $last_visit_date = $last_visit['updated_at'];
                                            }else{
                                                $last_visit_date = $last_visit['created_at'];
                                            }

                                         ?>
                                      <p><strong>Date:</strong> <?= date('d M Y, h:i A', strtotime($last_visit_date)) ?></p>
                                      <p><strong>Diagnosis:</strong> <?= nl2br($last_visit['diagnosis']) ?></p>
                                      <p><strong>Notes:</strong> <?= nl2br($last_visit['notes']) ?></p>

                                      <p>
                                          <strong>Doctor's Name:</strong>
                                          <?= $Staff_result['fname'] .' '.$Staff_result['lname'] ?>
                                      </p>

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

             

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

<?php require_once 'includes/footer.php'; ?>