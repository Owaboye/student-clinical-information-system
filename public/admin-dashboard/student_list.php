<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/filter-schedule.php'; ?>
<?php require_once 'includes/header.php'; ?>
<?php 
        // Allow only Doctor or Nurse
// dd($_SESSION['user']['role']);

    if (!in_array($_SESSION['user']['role'], ['Doctor', 'Nurse', 'Admin'])) {
        die("Access denied.");
    }

    $stmt = $pdo->query("
              SELECT u.*, sp.*, concat(u.fname, ' ', u.lname) as full_name, u.user_number, u.id as user_id
              FROM users u
              JOIN student_profiles sp ON sp.user_id = u.id
              WHERE u.role_id = 4
            ");

            $profiles = $stmt->fetchAll(); 


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
                             
                            <?php display_flash_message(); ?>
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                     <h3 class="m-0 font-weight-bold text-primary">Student Profile List </h3> 
                                </div>
                                
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
                                         <th>Status</th>
                                        <th>Submitted At</th>
                                       
                                        <th>Actions</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($profiles as $p): ?>
                                      <tr>
                                        <td><?= htmlspecialchars($p['full_name']) ?> (<?= htmlspecialchars($p['user_number']) ?>)</td>
                                        <td><?= htmlspecialchars($p['blood_type']) ?></td>
                                        <td><?= htmlspecialchars($p['genotype']) ?></td>
                                        <td><?= htmlspecialchars($p['approved']) ?></td>
                                        <td><?= htmlspecialchars($p['updated_at']) ?></td>
                                        <td>
                                          <a href="review_profile.php?id=<?= $p['id'] ?>" class="btn btn-primary btn-sm">Review</a>
                                          <a href="profile.php?id=<?= $p['user_id'] ?>" class="btn btn-info btn-sm">View</a>
                                        </td>
                                      </tr>
                                    <?php endforeach ?>
                                    </tbody>
                                  </table>
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