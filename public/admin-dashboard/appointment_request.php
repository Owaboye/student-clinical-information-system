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
                                    <h6 class="m-0 font-weight-bold text-primary">Request an Appointment</h6>
                                    <div class="dropdown no-arrow">
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
                                    </div>
                                </div>
                                <!-- Card Body -->
                                 <div class="card-body">
                                    <form method="post">
                                        <div class="row g-3 mb-3">
                                          <div class="col mb-3">
                                                  <label for="role_id" class="form-label">Select Doctor/Nurse</label>
                                                  <select class="form-control col" name="staff_id" id="role_id">
                                                    
                                                      <option value="">Select Doctor/Nurse</option>
                                                      <?php foreach ($staff as $s) { ?>
                                                        <option value="<?= $s['id'] ?>"><?= $s['full_name'] ?></option>
                                                     <?php } ?>
                                                     
                                                  </select>
                                                   <div class="text-danger"><?php echo $errors['user_role'] ?? ''  ?></div>
                                            </div>
                                          <div class="col">
                                            <div class="mb-3">
                                              <label>Date & Time</label>
                                              <input type="datetime-local" name="appointment_date" class="form-control"  min="<?= date('Y-m-d\TH:i') ?>" required>
                                            </div>
                                          </div>
                                        </div>
                                          
                                          <div class="mb-3">
                                              <label>Reason</label>
                                              <textarea name="reason" class="form-control"></textarea>
                                         </div>
                                          <div class="row d-flex justify-content-between">
                                              <button type="submit" class="btn btn-primary">Submit Request</button>

                                              <a href="<?= baseUrl('public/admin-dashboard/student-appointments.php') ?>" name="createUser" class="btn btn-success">View Appointments</a>
                                          </div>
                                        </form>
                                    
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
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

<?php require_once 'includes/footer.php'; ?>