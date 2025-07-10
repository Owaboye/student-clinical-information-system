<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/header.php'; ?>
    <!-- Page Wrapper -->
    <div id="wrapper">
<?php 

if (!isStaff()) {
    die("Access denied.");
}

$stmt = $pdo->query("
  SELECT sp.*, concat(u.fname, ' ', u.fname) as full_name, u.user_number
  FROM student_profiles sp
  JOIN users u ON sp.user_id = u.id
  WHERE sp.approved = 'pending'
");

$profiles = $stmt->fetchAll();

 ?>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Pending Student Health Profiles</h6>
                                    
                                </div>
                                <!-- Card Body -->
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
                                            <td><?= htmlspecialchars($p['full_name']) ?> (<?= htmlspecialchars($p['user_number']) ?>)</td>
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