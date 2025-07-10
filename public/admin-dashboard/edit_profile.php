<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/header.php'; ?>
<?php 

$user_id = $_SESSION['user']['id'];
$user =  usernameExit("users", "id", $user_id);

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
                   
                    <!-- Student Area -->
                    <?php if ($_SESSION['user']['role'] == 'Student') { ?>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-10 mb-4 mx-auto">
                            <?php display_flash_message(); ?>
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Edit my health prfile</h6>

                                    <a href="<?= baseUrl('public/admin-dashboard/appointment_request.php') ?>" name="createUser" class="btn btn-success">Request Appointments</a>
                                </div>
                                <?php 
                                $stmt = $pdo->prepare("SELECT * FROM student_profiles WHERE user_id = ?");
                                $stmt->execute([$user_id]);
                                $profile = $stmt->fetch();
                                ?>
                                <div class="card-body">
                                    
                                    <form method="POST" action="save_profile.php">
                                      <div class="mb-3">
                                        <label>Blood Type</label>
                                        <input type="text" name="blood_type" class="form-control" value="<?= htmlspecialchars($profile['blood_type'] ?? '') ?>" required>
                                      </div>
                                      <div class="mb-3">
                                        <label>Genotype</label>
                                        <input type="text" name="genotype" class="form-control" value="<?= htmlspecialchars($profile['genotype'] ?? '') ?>" required>
                                      </div>
                                      <div class="mb-3">
                                        <label>Allergies</label>
                                        <textarea name="allergies" class="form-control"><?= htmlspecialchars($profile['allergies'] ?? '') ?></textarea>
                                      </div>
                                      <div class="mb-3">
                                        <label>Chronic Conditions</label>
                                        <textarea name="chronic_conditions" class="form-control"><?= htmlspecialchars($profile['chronic_conditions'] ?? '') ?></textarea>
                                      </div>
                                      <div class="mb-3">
                                        <label>Emergency Contact Name</label>
                                        <input type="text" name="emergency_contact_name" class="form-control" value="<?= htmlspecialchars($profile['emergency_contact_name'] ?? '') ?>">
                                      </div>
                                      <div class="mb-3">
                                        <label>Emergency Contact Phone</label>
                                        <input type="text" name="emergency_contact_phone" class="form-control" value="<?= htmlspecialchars($profile['emergency_contact_phone'] ?? '') ?>">
                                      </div>
                                      <button type="submit" class="btn btn-success">Save</button>
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