<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/filter-schedule.php'; ?>
<?php require_once 'vendor/dompdf/autoload.inc.php'; ?>

<?php use Dompdf\Dompdf; ?>

<?php require_once 'includes/header.php'; ?>
<?php 
        // Allow only Doctor or Nurse
    if (!in_array($_SESSION['user']['role'], ['Doctor', 'Nurse'])) {
        die("Access denied.");
    }

    // $user_id = $_SESSION['user']['id'];
    // $user =  usernameExit("users", "id", $user_id);

    // $stmt = $pdo->prepare("SELECT a.*, CONCAT(u.fname, ' ', u.lname) AS student_name FROM appointments a
    // JOIN users u ON a.student_id = u.id
    // WHERE staff_id = ?
    // ORDER BY appointment_date ASC");

    // $stmt->execute([$user['id']]);
    // $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
                    <?php require_once 'includes/page-header.php' ?>
                   
                    <!-- Doctor Area -->
                    <?php if (in_array($_SESSION['user']['role'], ['Doctor', 'Nurse']) ) { ?>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-10 mb-4 mx-auto">
                             <?php 
                                if (!empty($result)) echo "<div class='alert alert-danger'>$result</div>"; 
                             ?>
                            <?php display_flash_message(); ?>
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">My Appointment Schedule</h6>

                                    
                                </div>
                                
                                <div class="card-body">
                                    <!-- Filter Form -->
                                <form method="GET" class="row g-3 mb-4">
                                <div class="col-md-3">
                                    <label>Start Date</label>
                                  <input type="date" name="start_date" value="<?= htmlspecialchars($startDate) ?>" class="form-control" placeholder="From Date">
                                </div>
                                <div class="col-md-3">
                                    <label>End date</label>
                                  <input type="date" name="end_date" value="<?= htmlspecialchars($endDate) ?>" class="form-control" placeholder="To Date">
                                </div>
                                <div class="col-md-3">
                                    <label>Select Status</label>
                                  <select name="status" class="form-control">
                                    
                                    <?php foreach (['Pending', 'Approved', 'Rejected', 'Completed'] as $opt): ?>
                                      <option value="<?= $opt ?>" <?= $status == $opt ? 'selected' : '' ?>><?= $opt ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="col-md-3">
                                    <label>&nbsp;</label>
                                  <button  class="btn btn-primary w-100" > Filter </button>
                                </div>
                                </form>
                                <?php if($appointments): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Student</th>
                                                    <th>Date</th>
                                                    <th>Reason</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                 <tr>
                                                    <th>Student</th>
                                                    <th>Date</th>
                                                    <th>Reason</th>
                                                    <th>Status</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach ($appointments as $a): ?>
                                                <tr>
                                                  <td><?= htmlspecialchars($a['student_name']) ?></td>
                                                  <td><?= date('Y-m-d H:i', strtotime($a['appointment_date'])) ?></td>
                                                  <td><?= htmlspecialchars($a['reason']) ?></td>
                                                  <?php $class = $a['status'] == 'Pending' ? 'danger' : 'success' ?>
                                                  <td><a class="btn btn-<?= $class ?>"> <?= $a['status'] ?> </a></td>
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