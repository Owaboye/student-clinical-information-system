<?php require_once 'config/database.php'; ?>
<?php require_once 'config/functions.php'; ?>
<?php
$token = $_GET['token'] ?? '';
    if (!$token) {
        $error = "Invalid token";
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = '';
    $error = '';
    $token = $_POST['token'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $reset = $stmt->fetch();

    if (!$reset) {
        $error = "Token expired or invalid. <a href='forgot_password.php'>Forgot Password</a>";
    }


    if (!$token || !$new_password){
        $error = "Invalid data";
    } 

    // dd($_POST['token']);

    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ?");
    $stmt->execute([$token]);
    $reset = $stmt->fetch();
    // dd($token);

    if (!$reset) {
        $error = "Token expired or invalid. <a href='forgot_password.php'>Forgot Password</a>";
    }

    // Update user password
    $hashed = password_hash($new_password, PASSWORD_BCRYPT);
    // dd("UPDATE users SET password_hash = $hashed WHERE user_number = $reset[user_number]");
    $stmt1 = $pdo->prepare("UPDATE users SET password_hash = ? WHERE user_number = ?");
    $stmt1->execute([$hashed, $reset['user_number']]);

    // Delete token
    $stmt2 = $pdo->prepare("DELETE FROM password_resets WHERE user_number = ?");
    $stmt2->execute([$reset['user_number']]);

    // $result = "Password reset successful. <a href='login.php'>Login</a>";
    header('Location: index.php');
    exit();


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crawford University Clinical Database Information System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= baseUrl('public/asset/css/style.css') ?>">
</head>
<body>
    <section class="bg-container">
        <div class="login-container">
        <header>
            <img src="<?= baseUrl('public/asset/images/crulogo.png') ?>" alt="University Logo" class="logo">
            <h4>Reset Password</h4>
        </header>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if (!empty($result)) echo "<div class='alert alert-success'>$result</div>"; ?>
        <form id="login-form" method="post">
            
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
              <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" required minlength="6">
              </div>
            <button class="btn btn-success">Reset Password</button>
            
           
        </form>
        
        <footer>
            <p>Secure login via SSL encryption</p>
        </footer>
    </div>
    </section>
</body>
</html>