<?php require_once '../config/functions.php'; ?>
<?php require_once '../includes/auth.php'; ?>
<?php require_once '../includes/header.php'; ?>

    <main class="px-3 text-center"> 
      <h1>SECURE CLINICAL DATABASE INFORMATION SYSTEM</h1> 
         <h3>Welcome, <?= htmlspecialchars($user['username']) ?> (<?= $user['role'] ?>)</h3>
          <p class="lead"> 
            <a href="<?= baseUrl('public/logout.php') ?>" class="btn btn-danger mt-3">Logout</a>


      </p> 
    </main> 
   
  <?php require_once '../includes/footer.php'; ?>