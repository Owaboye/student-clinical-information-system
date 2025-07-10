<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/header.php'; ?>
<?php 

$user_id = $_SESSION['user']['id'];
// $user =  usernameExit("users", "id", $user_id); 

// $sql = "select * from users where id = ?";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$user_id]);
// $user = $stmt->fetch(PDO::FETCH_ASSOC); 

$stmt1  = $pdo->prepare("
  SELECT * 
  FROM users u
  WHERE u.id = ?
");
$stmt1->execute([$user_id]);
$s = $stmt1->fetch();
// dd($user);
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

                    <div class="row mb-2">
                        <div class="col-md-10">
                            <h2>Welcome <?php echo $user['fname'] ?></h2>
                        </div>
                        <hr>
                    </div>

                    <!-- Page Heading -->
                    <?php //require_once 'includes/page-header.php' ?>
                    <?php display_flash_message() ?>
                    <!-- Content Row -->
                   <?php if ($_SESSION['user']['role'] == 'Admin') { ?>
                    <div class="row">



                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                <?php $appointments = getAll('appointments') ?>
                                                Appointments (Total)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count($appointments) ?? ""; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Users (Total)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php $users = getAll('users');
                                                echo count($users) ?? ''
                                             ?>
                                                
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Approved appointment
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        <?php 

$stmt = $pdo->query("
  SELECT 
    COUNT(*) AS total,
    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approved
  FROM appointments
");
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$total = $row['total'];
$approved = $row['approved'];

$percentage = ($total > 0) ? round(($approved / $total) * 100, 2) : 0;

echo "$approved";


                                                         ?>

                                                    </div>
                                                </div>
                                                <!-- <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Requests</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
<?php 

$stmt = $pdo->query("
  SELECT 
    COUNT(*) AS total,
    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS pending
  FROM appointments
");
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$total = $row['total'];
$pending = $row['pending'];

$percentage = ($total > 0) ? round(($pending / $total) * 100, 2) : 0;

echo "$pending";

 ?>
                                          

                                        </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student list -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">All Students</h6>
                                     
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <?php 
                                    // Get all students and join profile + latest consultation
                                    $stmt = $pdo->query("
                                      SELECT u.id, concat(u.fname, ' ', u.lname) as full_name, u.user_number, sp.blood_type, sp.genotype,
                                             (SELECT MAX(created_at) FROM consultations WHERE student_id = u.id) AS last_visit
                                      FROM users u
                                      LEFT JOIN student_profiles sp ON sp.user_id = u.id
                                      WHERE u.role_id = 4
                                      ORDER BY concat(u.fname, ' ', u.lname)
                                    ");
                                    $students = $stmt->fetchAll();

                                    if($students): 

                                    ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                              <thead class="table-light">
                                                <tr>
                                                  <th>Name</th>
                                                  <th>Matric Num</th>
                                                  <th>Blood Type</th>
                                                  <th>Genotype</th>
                                                  <th>Last Visit</th>
                                                  <th>Action</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <?php foreach ($students as $s): ?>
                                                  <tr>
                                                    <td><?= htmlspecialchars($s['full_name']) ?></td>
                                                    <td><?= htmlspecialchars($s['user_number']) ?></td>
                                                    <td><?= $s['blood_type'] ?? '—' ?></td>
                                                    <td><?= $s['genotype'] ?? '—' ?></td>
                                                    <td><?= $s['last_visit'] ? date('d M Y', strtotime($s['last_visit'])) : 'No visits yet' ?></td>
                                                    <td><a href="view_student.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-primary">View</a>
                                                         <a href="review_profile.php?id=<?= $p['id'] ?>" class="btn btn-info btn-sm">Review</a>
                                                    </td>
                                                  </tr>

                                                 
                                                <?php endforeach ?>
                                              </tbody>
                                            </table>
                                    </div>
                                <?php else: ?>
                                        <p class="lead">No Student yet</p>
                                <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>


<!-- Appointment list -->
                    <div class="row">

                        <!-- Area Chart -->
                        

                        <!-- Pie Chart -->
                        <div class="col-xl-12 col-lg-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Doctor List </h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                   

                                    <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                             <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>User ID</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>User ID</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        <?php 
                                        $userLimit = getAll('users', 5);

                                        if (count($userLimit) > 0) :  ?>
                                            <?php foreach($userLimit as $user): ?>
                                                <?php 



                                                $role = usernameExit('roles', 'id', $user['role_id']);
                                                if($role['name'] == 'Doctor' || $role['name'] == 'Nurse'):

                                                 ?>
                                            <tr>
                                                <td><?php echo $user['fname'] ?? '' ?></td>
                                                <td><?php echo $user['lname'] ?? '' ?></td>
                                                <td><?php echo $user['email'] ?? '' ?></td>

                                                <td><?php echo $role['name'] ?? '' ?></td>
                                                <td><?php echo $user['user_number'] ?? '' ?></td>
                                                <td>
                                                    <a href="<?= baseUrl('public/admin-dashboard/user-update.php?user_id='.$user['id']) ?>" class="btn btn-success btn-circle btn-sm">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <a href="<?= baseUrl('public/admin-dashboard/user-delete.php?delete_id='.$user['id']) ?>" class="btn btn-danger btn-circle btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endif ?>
                                        <?php endforeach ?>
                                    <?php else: ?>

                                        <p class="lead">No record found</p>

                                    <?php endif ?>
                                        
                                       
                                       
                                        
                                    </tbody>
                                </table>
                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>




                    <!-- Student Area -->
                    <?php if ($_SESSION['user']['role'] == 'Student') { ?>
                    <!-- Content Row -->
                    <div class="row">
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
                        <!-- Content Column -->
                        <div class="col-lg-8 mb-4">
                            <!-- Dashboard -->
                            

                            <!-- Student Profile -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Student Health Profile</h6>
                                </div>
                                
                                <div class="card-body">
                                    <h3>Welcome, <?= htmlspecialchars($user['fname']) ?></h3>
                                    
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

                            <!-- Color System -->

                            <!-- 2. Last Visit Info -->
<!-- <div class="card mb-4">
  <div class="card-header bg-secondary text-white"></div>
  <div class="card-body">
    
  </div>
</div> -->

<!-- 3. Actions -->
<!-- <div class="d-flex gap-3">
  <a href="appointment_request.php" class="btn btn-success">Book Appointment</a>
  <a href="request_lab_test.php" class="btn btn-warning">Request Lab Test</a>
</div> -->
                           

                        </div>

                        <div class="col-lg-4 mb-4">

                            <!-- Illustrations -->
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
                    <?php } ?>


                                    <!-- Nurse or Doctor -->
                    <?php if (in_array($_SESSION['user']['role'], ['Doctor', 'Nurse'])) { ?>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Student profile -->
                        <div class="col-lg-10 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Pending Student Health Profiles</h6>
                                </div>
                                <?php 

                                    $stmt = $pdo->query("
                                      SELECT sp.*, concat(u.fname, ' ', u.lname) as full_name, u.username
                                      FROM student_profiles sp
                                      JOIN users u ON sp.user_id = u.id
                                      WHERE sp.approved = 'pending'
                                    ");

                                    $profiles = $stmt->fetchAll(); 
                                 ?>
                                <div class="card-body">
                                   
                               <?php if (empty($profiles)): ?>
                                  <div class="alert alert-info">No pending profiles at the moment.</div>
                                <?php else: ?>
                                  <table class="table table-bordered">
                                    <thead class="table-light">
                                      <tr>
                                        <th>Student</th>
                                        <th>Blood Type</th>
                                        <th>Genotype</th>
                                        <th>Submitted At</th>
                                        <th>Actions</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($profiles as $p): ?>
                                      <tr>
                                        <td><?= htmlspecialchars($p['full_name']) ?> (<?= htmlspecialchars($p['username']) ?>)</td>
                                        <td><?= htmlspecialchars($p['blood_type']) ?></td>
                                        <td><?= htmlspecialchars($p['genotype']) ?></td>
                                        <td><?= htmlspecialchars($p['updated_at']) ?></td>
                                        <td>
                                          <a href="review_profile.php?id=<?= $p['id'] ?>" class="btn btn-primary btn-sm">Review</a>
                                        </td>
                                      </tr>
                                    <?php endforeach ?>
                                    </tbody>
                                  </table>
                                <?php endif ?>
                                   
                                    
                                </div>
                            </div>

                            <!-- Color System -->
                           

                        </div>

                        <!-- Consultation -->
                        <div class="col-lg-10 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">My Schedule</h6>
                                </div>
                                <?php 
                                    $stmt = $pdo->prepare("SELECT a.*, CONCAT(u.fname, ' ', u.lname) AS student_name FROM appointments a
                                        JOIN users u ON a.student_id = u.id
                                        WHERE staff_id = ?
                                        ORDER BY appointment_date ASC");

                                    $stmt->execute([$user['id']]);
                                    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                 ?>
                                <div class="card-body">
                                    <?php if($appointments): ?>
                                        <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Date</th>
                                                    <th>Reason</th>
                                                    <th>Status</th>
                                                    <th>Consult</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                 <tr>
                                                    <th>Student Name</th>
                                                    <th>Date</th>
                                                    <th>Reason</th>
                                                    <th>Status</th>
                                                    <th>Consult</th>
                                                    <th>Change Status</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>

                                                <?php foreach ($appointments as $appointment): ?>
                                                <tr>
                                                  <td><?= htmlspecialchars($appointment['student_name']) ?></td>
                                                  <td><?= date('Y-m-d H:i', strtotime($appointment['appointment_date'])) ?></td>
                                                  <td><?= htmlspecialchars($appointment['reason']) ?></td>
                                                 <td>
                                                       <?= $appointment['status'] ?>
                                                  </td>
                                                  
                                                  <td><a href="<?= baseUrl('public/admin-dashboard/consultation_form.php?appointment_id='.$appointment['id'])  ?>">Consultation    </a>
                                                  </td>
                                                  
                                                  <td>
                                                      <form method="POST" class="d-inline" action="<?= baseUrl('public/admin-dashboard/approve-appointment.php') ?>">
                                                      <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                                      <!-- <input type="hidden"  value="Approved"> -->
                                                      
                                                     <div class="row">
                                                         <select class="form-control col mr-2" name="status" id="status">
                                                    
                                                        <option value="">All Status</option>
                                                        <?php foreach (['Pending', 'Approved', 'Rejected', 'Completed'] as $opt): ?>
                                                          <option value="<?= $opt ?>"><?= $opt ?></option>
                                                        <?php endforeach; ?>
                                                     
                                                     
                                                      </select>
                                                      <input type="submit" name="approveBtn" class="btn btn-success btn-sm col" value="Change">
                                                     </div>
                                                    </form>

                                                  </td>
                                                </tr>
                                              <?php endforeach; ?>
                                           
                                            </tbody>
                                        </table>
                            </div>
                                    <?php else: ?>
                                        <p class="lead">No apointment yet</p>
                                    <?php endif ?>
                                    
                                </div>
                            </div>

                            <!-- Color System -->
                           

                        </div>

                        <!-- <div class="col-lg-4 mb-4">

                           Illustrations -->
                            <!-- <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Consultation Request</h6>
                                </div>
                               
                                <div class="card-body">
                                    
                                    
                                </div>
                            </div> -->
                        <!--  </div> -->
                    </div>
                    <?php } ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once 'includes/copy-right.php'; ?>
            <!-- End of Footer SECURE CLINICAL DATABASE INFORMATION SYSTEM FOR STUDENT HEALTH MANAGEMENT-->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

<?php require_once 'includes/footer.php'; ?>