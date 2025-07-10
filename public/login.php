<?php require_once '../config/database.php'; ?>
<?php require_once '../config/functions.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_number = $_POST['user_number'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT users.*, roles.name AS role_name FROM users 
                           JOIN roles ON users.role_id = roles.id 
                           WHERE user_number = ?");
    $stmt->execute([$user_number]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'fname' => $user['fname'],
            'role' => $user['role_name']
        ];

        header("Location: ".baseUrl('public/admin-dashboard'));

        exit;
    } else {
        $error = "Invalid login credentials.";
    }
}

$roles = getAll('roles');

?>

<!-- HTML Form (Bootstrap styled) -->

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
            <h1>Student Health Portal</h1>
        </header>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form id="login-form" method="post">
            
            
            <div class="form-group">
                <label for="id">Matric Number:</label>
                <input type="text" id="id" required name="user_number" value="<?= $user_number ?? '' ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" required name="password" value="<?= $password ?? '' ?>">
            </div>

            <div class="form-group">
                <label for="role">Member</label>
                <select id="role" required name="roll_id">
                    <option value="">Select Role</option>
                    <?php foreach ($roles as $role) { ?>
                        <option value="<?= $role['id']  ?>"><?= $role['name']  ?></option>
                    <?php  } ?>
                    
                </select>
            </div>
            
            <button type="submit" class="btn-login">Login</button>
            
            <div class="forgot-password">
                <a href="../forgot_password.php">Forgot Password?</a>
            </div>
        </form>
        
        <footer>
            <p>Secure login via SSL encryption</p>
        </footer>
    </div>
    </section>
    
</body>
</html>
