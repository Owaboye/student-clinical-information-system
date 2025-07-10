<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/create-user.php'; ?>
<?php // Allow only Admins
    if ($user['role'] !== 'Admin') {
        die("Access denied. Admins only.");
    } 
?>
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
                   <?php //if (!empty($result)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-10 col-sm-10 mx-auto">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Create User</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="<?= baseUrl('public/admin-dashboard/user-index.php') ?>">View User</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div> -->
                                    <form method="post">
                                        <div class="row g-3 mb-3">
                                          <div class="col">
                                            <label for="exampleInputEmail1" class="form-label">First Name</label>
                                            <input type="text" name="fname" class="form-control" placeholder="First name" aria-label="First name" value="<?php echo $fname ?? ''; ?>">
                                            <div class="text-danger"><?php echo $errors['fname'] ?? ''  ?></div>
                                          </div>
                                          <div class="col">
                                            <label for="exampleInputEmail1" class="form-label">Last Name</label>
                                            <input type="text" name="lname" class="form-control" placeholder="Last name" aria-label="Last name" value="<?php echo $lname ?? ''; ?>">
                                             <div class="text-danger"><?php echo $errors['lname'] ?? ''  ?></div>
                                          </div>
                                        </div>
                                          <div class="row">
                                              <div class="mb-3 col">
                                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $email ?? ''; ?>">
                                                 <div class="text-danger"><?php echo $errors['email'] ?? ''  ?></div>
                                                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                                              </div>
                                             
                                              <div class="col mb-3">
                                                  <label for="role_id" class="form-label">Select Role</label>
                                                  <select class="form-control col" name="role_id" id="role_id">
                                                    
                                                      <option value="">Select Role</option>
                                                      <?php foreach ($roles as $role) { ?>
                                                        <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                                                     <?php } ?>
                                                     
                                                  </select>
                                                   <div class="text-danger"><?php echo $errors['user_role'] ?? ''  ?></div>
                                              </div>
                                          </div>
                                          <div class="row g-3 mb-3">
                                              <div class="col">
                                                <label for="user_number" class="form-label">Matric/Employee ID</label>
                                                <input type="text" name="user_number" class="form-control" placeholder="Matric/Employee ID" id="user_number" value="<?php echo $user_number ?? ''; ?>">
                                                 <div class="text-danger"><?php echo $errors['user_number'] ?? ''  ?></div>
                                              </div>
                                              <div class="col">
                                                <label for="user_number" class="form-label">Department</label>
                                                <input type="text" name="dept" class="form-control" placeholder="Department" value="<?php echo $dept ?? ''; ?>">
                                              </div>
                                            </div>
                                          <div class="row d-flex justify-content-between">
                                              <button type="submit" name="createUser" class="btn btn-primary">Register</button>

                                              <a href="<?= baseUrl('public/admin-dashboard/user-index.php') ?>" name="createUser" class="btn btn-success">View Users</a>
                                          </div>
                                        </form>
                                </div>
                            </div>
                        </div>

                        
                    </div>

                    <!-- Content Row -->
                    <!-- <div class="row"> -->

                        <!-- Content Column -->
                        <!-- <div class="col-lg-10 mb-4"> -->

                            <!-- Project Card Example -->
                           <!--  <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">User List</h6>
                                </div>
                                <div class="card-body">
                                    
                                    
                                    
                                    
                                   
                                </div>
                            </div>     -->                        

                        <!-- </div> -->
                    <!-- </div> -->

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