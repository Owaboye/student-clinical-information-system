<?php require_once '../../config/database.php'; ?>
<?php require_once '../../config/functions.php'; ?>
<?php require_once '../../includes/auth.php'; ?>
<?php require_once 'includes/filter-schedule.php'; ?>

<?php require_once 'includes/header.php'; ?>
<?php 
        // Allow only Doctor or Nurse
    if (!in_array($_SESSION['user']['role'], ['Doctor', 'Nurse', 'Admin'])) {
        die("Access denied.");
    }

    $id = $_GET['id'] ?? null;

    if (!$id) {
        die("Consultation ID missing.");
    }

    // Fetch consultation
    $stmt = $pdo->prepare("SELECT c.*, 
      CONCAT(s.fname, ' ', s.lname) AS student_name, s.username AS student_username,
      CONCAT(u.fname, ' ', u.lname) AS staff_name, u.username AS staff_username
      FROM consultations c
      JOIN users s ON c.student_id = s.id
      JOIN users u ON c.staff_id = u.id
      WHERE c.id = ?");
    $stmt->execute([$id]);
    $consultation = $stmt->fetch();

    if (!$consultation) {
        die("Consultation not found.");
    }

    // Fetch prescriptions
    $stmt2 = $pdo->prepare("SELECT * FROM prescriptions WHERE consultation_id = ?");
    $stmt2->execute([$id]);
    $prescriptions = $stmt2->fetchAll();

    // Fetch consultation file
    $stmt_files = $pdo->prepare("SELECT * FROM consultation_files WHERE consultation_id = ?");
    $stmt_files->execute([$consultation['id']]);
    $files = $stmt_files->fetchAll();

    // Lab result
    $stmt_lab = $pdo->prepare("SELECT * FROM lab_results WHERE consultation_id = ?");
    $stmt_lab->execute([$consultation['id']]);
    $lab_results = $stmt_lab->fetchAll();

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
                                     <h3>Consultation Details</h3>
                                     <a href="export_consultation_pdf.php?id=<?= $consultation['id'] ?>" class="btn btn-outline-danger no-print">Export to PDF</a>
                                    <button onclick="window.print()" class="btn btn-outline-secondary no-print">Print</button>
                                </div>
                                
                                <div class="card-body">
                                      <h5>Student Info</h5>
                                        <p><strong>Name:</strong> <?= htmlspecialchars($consultation['student_name']) ?>  
                                        (<?= htmlspecialchars($consultation['student_username']) ?>)</p>
                                        <hr>
                                        <h5>Staff Info</h5>
                                        <p><strong>By:</strong> <?= htmlspecialchars($consultation['staff_name']) ?>  
                                        (<?= htmlspecialchars($consultation['staff_username']) ?>)</p>
                                        <hr>
                                        <h5>Date</h5>
                                        <p><?= date('Y-m-d H:i', strtotime($consultation['created_at'])) ?></p>
                                        <hr>
                                        <h5>Diagnosis</h5>
                                        <p><?= nl2br(htmlspecialchars($consultation['diagnosis'])) ?></p>

                                        <h5>Notes</h5>
                                        <p><?= nl2br(htmlspecialchars($consultation['notes'])) ?></p>            
                                        <?php if ($lab_results): ?>
                                            <hr>
                                          <h5>Lab Result</h5>
                                          <ul>
                                            <?php foreach ($lab_results as $result): ?>
                                                <li>
                                              
                                                <?= htmlspecialchars($result['title']) ?>
                                              </a>
                                              
                                            </li>
                                              <li>
                                              <?= htmlspecialchars($result['title']) ?>
                                              
                                              <?php if (isStaff()): ?>
                                                <a href="delete_lab_result.php?id=<?= $result['id'] ?>" class="text-danger ms-2"
                                                   onclick="return confirm('Delete this file?');">[Delete]</a>
                                              <?php endif ?>
                                            </li>
                                            <?php endforeach ?>
                                          </ul>
                                        <?php endif ?> 
                                        <hr>
                                        <?php if ($files): ?>
                                          <h5>Attached Files</h5>
                                          <ul>
                                            <?php foreach ($files as $f): ?>
                                              <li>
                                              <a href="<?= htmlspecialchars($f['file_path']) ?>" target="_blank">
                                                <?= htmlspecialchars($f['file_name']) ?>
                                              </a>
                                              <small class="text-muted">(Uploaded <?= date('Y-m-d', strtotime($f['uploaded_at'])) ?>)</small>
                                              <?php if (isStaff()): ?>
                                                <a href="delete_consultation_file.php?id=<?= $f['id'] ?>" class="text-danger ms-2"
                                                   onclick="return confirm('Delete this file?');">[Delete]</a>
                                              <?php endif ?>
                                            </li>
                                            <?php endforeach ?>
                                          </ul>
                                        <?php endif ?>                           
                                        <hr>
                                        <?php if ($prescriptions): ?>
                          <h5>Prescriptions</h5>
                          <table class="table table-bordered">
                            <thead class="table-light">
                              <tr>
                                <th>#</th>
                                <th>Medication</th>
                                <th>Dosage</th>
                                <th>Frequency</th>
                                <th>Duration</th>
                                <th>Instructions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($prescriptions as $i => $p): ?>
                                <tr>
                                  <td><?= $i + 1 ?></td>
                                  <td><?= htmlspecialchars($p['medication_name']) ?></td>
                                  <td><?= htmlspecialchars($p['dosage']) ?></td>
                                  <td><?= htmlspecialchars($p['frequency']) ?></td>
                                  <td><?= htmlspecialchars($p['duration']) ?></td>
                                  <td><?= nl2br(htmlspecialchars($p['instructions'])) ?></td>
                                </tr>
                              <?php endforeach ?>
                            </tbody>
                          </table>
                        <?php else: ?>
                          <p><em>No prescriptions recorded.</em></p>
                        <?php endif ?>

                

<div class="no-print mt-4">
    <form method="post" action="approve_consultation_action.php" class="mt-3">
      <input type="hidden" name="id" value="<?= $consultation['id'] ?>">
      <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
      <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
      <a href="admin_consultations_list.php" class="btn btn-secondary">Back</a>
    </form>
  
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
          
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

<?php require_once 'includes/footer.php'; ?>