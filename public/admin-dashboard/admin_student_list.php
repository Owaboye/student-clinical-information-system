<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'vendor/dompdf/autoload.inc.php'; ?>
<?php require_once 'includes/admin-filter-appointments.php'; ?>
<?php use Dompdf\Dompdf; ?>

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
                            <?php display_flash_message(); ?>
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <!-- <div class="card-header py-3 d-flex justify-content-between">
                                   

                                </div> -->
                                
                                <div class="card-body">
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
                                      SELECT u.id, sp.id as student_profile_id, concat(u.fname, ' ', u.lname) as full_name, u.user_number, sp.blood_type, sp.genotype,
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
                                                        <a href="review_profile.php?id=<?= $s['student_profile_id'] ?>" class="btn btn-info btn-sm">Review</a>
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
                        <span>Copyright &copy; Your Website <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

<?php require_once 'includes/footer.php'; ?>