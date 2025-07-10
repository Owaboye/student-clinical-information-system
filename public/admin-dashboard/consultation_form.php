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


$appointment_id = $_GET['appointment_id'] ?? null;

// Get appointment & student info
$stmt = $pdo->prepare("SELECT a.*, CONCAT(s.fname, ' ', s.lname) AS student_name, s.id AS student_id 
                       FROM appointments a 
                       JOIN users s ON a.student_id = s.id 
                       WHERE a.id = ?");
$stmt->execute([$appointment_id]);
$appointment = $stmt->fetch();

if (!$appointment) {
    die("Appointment not found.");
}

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
                                     <h3 class="m-0 font-weight-bold text-primary">Consultation for <?= htmlspecialchars($appointment['student_name']) ?></h3> 
                                </div>
                                
                                <div class="card-body">
                                                  
                                    <form action="save_consultation.php" method="POST" enctype="multipart/form-data">
                                      <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                      <input type="hidden" name="student_id" value="<?= $appointment['student_id'] ?>">

                                      <div class="mb-3">
                                        <label>Diagnosis</label>
                                        <textarea name="diagnosis" class="form-control" rows="2" required></textarea>
                                      </div>

                                      <div class="mb-3">
                                        <label>Consultation Notes</label>
                                        <textarea name="notes" class="form-control" rows="4" required></textarea>
                                      </div>
                                      
                                        <hr>
                                      <h5>Prescriptions</h5>
                                      <div id="prescription-container"></div>
                                      <button type="button" class="btn btn-secondary btn-sm" onclick="addPrescription()">+ Add Prescription</button>

                                      <hr>

                                      <h5>Lab Results</h5>
                                        <div id="lab-results-container"></div>
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="addLabResult()">+ Add Lab Result</button>
                                      <hr>

                                        <h5>Upload Attachments (PDF, JPG, PNG, etc.)</h5>
                                        <input type="file" name="attachments[]" class="form-control" multiple>
                                        <small class="text-muted">Max size per file: 2MB</small>
                                      <div class="mt-3">
                                          <button type="submit" class="btn btn-primary">Save Consultation</button>
                                      </div>
                                    </form>

                                    <script>
                                    function addPrescription() {
                                      const container = document.getElementById("prescription-container");
                                      const index = container.children.length;

                                      const html = `
                                      <div class="border p-2 mt-2">
                                        <div class="row">
                                          <div class="col-md-4">
                                            <label>Medication</label>
                                            <input type="text" name="prescriptions[${index}][medication_name]" class="form-control" required>
                                          </div>
                                          <div class="col-md-2">
                                            <label>Dosage</label>
                                            <input type="text" name="prescriptions[${index}][dosage]" class="form-control" required>
                                          </div>
                                          <div class="col-md-2">
                                            <label>Frequency</label>
                                            <input type="text" name="prescriptions[${index}][frequency]" class="form-control">
                                          </div>
                                          <div class="col-md-2">
                                            <label>Duration</label>
                                            <input type="text" name="prescriptions[${index}][duration]" class="form-control">
                                          </div>
                                          <div class="col-md-12 mt-1">
                                            <label>Instructions</label>
                                            <textarea name="prescriptions[${index}][instructions]" class="form-control" rows="2"></textarea>
                                          </div>
                                        </div>
                                      </div>`;
                                      container.insertAdjacentHTML('beforeend', html);
                                    }

                                    function addLabResult() {
                                      const container = document.getElementById("lab-results-container");
                                      const index = container.children.length;

                                      const html = `
                                        <div class="border p-2 mt-2">
                                          <div class="mb-2">
                                            <label>Title</label>
                                            <input type="text" name="lab_results[${index}][title]" class="form-control" required>
                                          </div>
                                          <div class="mb-2">
                                            <label>Result</label>
                                            <textarea name="lab_results[${index}][result]" class="form-control" rows="2" required></textarea>
                                          </div>
                                        </div>
                                      `;
                                      container.insertAdjacentHTML('beforeend', html);
                                    }
                                                                        </script>


                                       
                                       
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