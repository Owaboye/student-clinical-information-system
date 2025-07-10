<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/filter-schedule.php'; ?>
<?php require_once 'includes/header.php'; ?>
<?php 
        // Allow only Doctor or Nurse
    if (!in_array($_SESSION['user']['role'], ['Doctor', 'Nurse'])) {
        die("Access denied.");
    }

$search = $_GET['search'] ?? '';
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

$where = [];
$params = [];

if (!empty($search)) {
    $where[] = "(s.username LIKE :search OR s.full_name LIKE :search)";
    $params[':search'] = "%$search%";
}

if (!empty($from)) {
    $where[] = "DATE(c.created_at) >= :from";
    $params[':from'] = $from;
}
if (!empty($to)) {
    $where[] = "DATE(c.created_at) <= :to";
    $params[':to'] = $to;
}

$sql = "SELECT c.*, CONCAT(s.fname, ' ', s.lname) AS student_name, CONCAT(u.fname, ' ', u.lname) AS staff_name 
        FROM consultations c
        JOIN users s ON c.student_id = s.id
        JOIN users u ON c.staff_id = u.id";

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY c.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$consultations = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <?php if (in_array($_SESSION['user']['role'], ['Doctor', 'Nurse']) ) { ?>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-10 mb-4 mx-auto">
                             
                            <?php display_flash_message(); ?>
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                     <h3 class="m-0 font-weight-bold text-primary">Consultation List </h3> 
                                </div>
                                
                                <div class="card-body">
                               
                           <form class="row g-2 mb-3" method="GET">
                              <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Student name..." value="<?= htmlspecialchars($search) ?>">
                              </div>
                              <div class="col-md-2">
                                <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($from) ?>">
                              </div>
                              <div class="col-md-2">
                                <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($to) ?>">
                              </div>
                              <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="consultations_list.php" class="btn btn-secondary">Reset</a>
                              </div>
                            </form>

                            <div class="table-resposive">
                                                            <table class="table table-bordered table-striped">
                              <thead class="table-light">
                                <tr>
                                  <th>#</th>
                                  <th>Student</th>
                                  <th>Staff</th>
                                  <th>Diagnosis</th>
                                  <th>Date</th>
                                  <th>Status</th>
                                  <th>Export PDF</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($consultations as $i => $c): ?>
                                  <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($c['student_name']) ?></td>
                                    <td><?= htmlspecialchars($c['staff_name']) ?></td>
                                    <td><?= htmlspecialchars($c['diagnosis']) ?></td>
                                    <td><?= date('Y-m-d H:i', strtotime($c['created_at'])) ?></td>
                                     <td><?= $c['status'] ?></td>
                                    <td>
                                        <a href="export_consultation_pdf.php?id=<?= $c['id'] ?>" class="btn btn-outline-danger no-print" target='_blank'>Export to PDF</a>
                                    </td>
                                    <td>
                                      <a href="view_consultation.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-info">View</a>

                                      <!-- Optionally: delete/edit links -->
                                    </td>
                                    
                                  </tr>
                                <?php endforeach ?>
                              </tbody>
                            </table>
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