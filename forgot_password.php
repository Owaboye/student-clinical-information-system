<?php require_once 'config/database.php'; ?>
<?php require_once 'config/functions.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $error = '';

$user_number = $_POST['user_number'] ?? '';
if (!$user_number) {
    $error = "Matric number required";
}

// Check if user exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_number = ?");
$stmt->execute([$user_number]);
$user = $stmt->fetch();



if (!$user){
 $error = "No account found with that Matric number.";
 
}else{
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+30 minutes'));

    // Save token
    $stmt = $pdo->prepare("INSERT INTO password_resets (user_number, token, expires_at) VALUES (?, ?, ?)");
    $stmt->execute([$user_number, $token, $expires]);

    $error = "Pleae click <a href='reset_password.php?token=$token'>here</a> to reset your password.";
}

// Generate token


// Send email
// $reset_link = "http://yourdomain.com/reset_password.php?token=$token";
// $subject = "Password Reset Request";
// $message = "Hi,\n\nClick the link below to reset your password:\n$reset_link\n\nThis link expires in 30 minutes.";
// $headers = "From: clinic@crawforduniversity.edu.ng";

// mail($email, $subject, $message, $headers);


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
            <h4>Forgot Your Password?</h4>
        </header>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form id="login-form" method="post">
            
            <div class="form-group">
                <label for="id">ID Number:</label>
                <input type="text" id="id" required name="user_number" value="<?= $user_number ?? '' ?>">
            </div>
            
            
            <button type="submit" class="btn-login">Reset Password</button>
            
           
        </form>
        
        <footer>
            <p>Secure login via SSL encryption</p>
        </footer>
    </div>
    </section>
</body>
</html>