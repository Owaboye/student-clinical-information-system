<?php require_once '../config/database.php'; ?>
<?php require_once '../config/functions.php'; ?>
<?php require_once '../includes/header.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT users.*, roles.name AS role_name FROM users 
                           JOIN roles ON users.role_id = roles.id 
                           WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role_name']
        ];
        header("Location: ".baseUrl('public/admin-dashboard'));
        exit;
    } else {
        $error = "Invalid login credentials.";
    }
}
?>
<!-- HTML Form (Bootstrap styled) -->

    <main class="px-3"> 
      <h1>Sign in</h1> 
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?//= password_hash("admin123", PASSWORD_DEFAULT) ?>
      <form method="post">
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>

  
    </main> 
   
  <?php require_once '../includes/footer.php'; ?>