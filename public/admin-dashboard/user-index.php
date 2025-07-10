<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php //require_once 'includes/create-user.php'; ?>
<?php require_once 'includes/admin-filter-users.php'; ?>
<?php 

// Allow only Admins
    if ($_SESSION['user']['role'] !== 'Admin') {
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
                
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12 col-sm-12 mx-auto">
                            <div class="card shadow mb-4">
                                <?php display_flash_message(); ?>
                                <!-- Card Header - Dropdown -->
                                <!-- Filter form -->

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">User List</h6>
                                    <a href="<?= baseUrl('public/admin-dashboard/export_users_pdf.php') ?>?<?= http_build_query($_GET) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="<?= baseUrl('public/admin-dashboard/user-create.php') ?>">Create User</a>
                                            <!-- <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a> -->
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Filter form -->
                            <form method="GET" class="row g-3 mb-4">
                                <div class="col-md-3">
                                    <label>Date</label>
                                  <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?? '' ?>" class="form-control" placeholder="Date">
                                </div>
                                
                                <div class="col-md-3">
                                    <label>Select Status</label>
                                  <select name="role" class="form-control">
                                    
                                    <?php foreach ($roles as $opt): ?>
                                      <option value="<?= $opt['id'] ?>" <?= $status == $opt['id'] ? 'selected' : '' ?>><?= $opt['name'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="col-md-3">
                                    <label>&nbsp;</label>
                                  <button  class="btn btn-primary w-100" > Filter </button>
                                </div>
                            </form>
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
                                        <?php if (count($users) > 0) :  ?>
                                            <?php foreach($users as $user): ?>
                                                <?php 

                                                $role = usernameExit('roles', 'id', $user['role_id']);

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

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-10 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">User List</h6>
                                </div>
                                <div class="card-body">
                                    
                                    
                                    
                                    
                                   
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