<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= baseUrl('public/admin-dashboard/index.php') ?>" style="margin: 15px 0;">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="<?= baseUrl('public/asset/images/crulogo.png') ?>" alt="University Logo" class="logo" width="100" class="logo" style="width: 50px;">
                </div>
                <div class="sidebar-brand-text mx-3">CDIS <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?= baseUrl('public/admin-dashboard/index.php') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Admin user -->
            <?php if ($_SESSION['user']['role'] == 'Admin') { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= baseUrl('public/admin-dashboard/admin_consultations_list.php') ?>">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Consultation</span></a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="<?= baseUrl('public/admin-dashboard/admin_student_list.php') ?>">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Student Profile</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= baseUrl('public/admin-dashboard/admin_view_appointments.php')  ?>">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Manage Appointments</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Users</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">User Section:</h6>
                            <a class="collapse-item" href="<?= baseUrl('public/admin-dashboard/user-index.php') ?>">Users</a>
                            <a class="collapse-item" href="<?= baseUrl('public/admin-dashboard/user-create.php') ?>">Create User</a>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <!-- Nav Item - Student -->
            <?php if ($_SESSION['user']['role'] == 'Student') { ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Student</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Appointment</h6>
                            <a class="collapse-item" href="<?= baseUrl('public/admin-dashboard/student-appointments.php') ?>">Appointment</a>
                            <a class="collapse-item" href="<?= baseUrl('public/admin-dashboard/appointment_request.php') ?>">Appointment Request</a>
                            <!-- <a class="collapse-item" href="">Animations</a>
                            <a class="collapse-item" href="#">Other</a> -->
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= baseUrl('public/admin-dashboard/student_profiles.php') ?>">
                        <i class="fas fa-fw fa-table"></i>
                        <span>My Profile</span>
                    </a>
                </li>
            <?php } ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Addons
            </div> -->

            <!-- Nav Item - Doctor -->
            <?php if (in_array($_SESSION['user']['role'], ['Doctor', 'Nurse']) ) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= baseUrl('public/admin-dashboard/consultations_list.php') ?>">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Consultation</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= baseUrl('public/admin-dashboard/student_list.php') ?>">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Student Profile</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Schedule</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">My Schedule:</h6>
                        <a class="collapse-item" href="<?= baseUrl('public/admin-dashboard/my_schedule.php') ?>">View</a>
                       
                    </div>
                </div>
                </li>
            <?php } ?>
            

        </ul>