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
                                    <h6 class="m-0 font-weight-bold text-primary">Appointments</h6>

                                    <a href="<?= baseUrl('public/admin-dashboard/appointment_request.php') ?>" name="createUser" class="btn btn-success">Request Appointments</a>
                                </div>
                                <?php $appointments = findBy("appointments", "student_id", $user_id); ?>
                                <div class="card-body">
                                <?php if($appointments): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Reason</th>
                                                    
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Reason</th>
                                                    
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php //$appointments = findBy('appointments', 'student_id', $user_id);
                                            foreach ($appointments as $appointment ) :?>
                                                <?php 

                                                    $staff_db = usernameExit('users', 'id', $appointment['staff_id']);
                                                    $staff_role = usernameExit('roles', 'id', $staff_db['role_id']) 

                                                 ?>
                                                <tr>
                                                   
                                                    <td><?php echo $staff_db['fname'].' '.$staff_db['lname'] ?></td>

                                                    <td><?php echo $staff_role['name'] ?></td>
                                                     <td><?php echo $appointment['reason'] ?></td>
                                                    <td><?php echo $appointment['appointment_date'] ?></td>
                                                    <td><?php echo $appointment['status'] ?></td>
                                                    <td>
                                                        <a href="<?= baseUrl('public/admin-dashboard/appointment_edit.php?appointment_id='.$appointment['id']) ?>" class="btn btn-success btn-circle btn-sm">
                                                        <i class="fas fa-check"></i>
                                                        </a>
                                                        <a href="<?= baseUrl('public/admin-dashboard/appointment_delete.php?delete_id='.$appointment['id']) ?>" class="btn btn-danger btn-circle btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
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