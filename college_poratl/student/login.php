<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pwd = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=? AND role='student'");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pwd, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-bg">

<div class="container">
<h2>Student Login</h2>
<form method="POST">
<input type="email" name="email" required>
<input type="password" name="password" required>
<button>Login</button>
</form>
<?php if(isset($error)) echo $error; ?>
</div>
</body>
</html>
