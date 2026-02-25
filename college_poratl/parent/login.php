<?php
session_start();
require_once '../includes/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM parents WHERE email = ?");
    $stmt->execute([$email]);
    $parent = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($parent && password_verify($password, $parent['password'])) {
        $_SESSION['parent'] = $parent;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "❌ Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Parent Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-bg">

<div class="container">
    <h2>Parent Login</h2>
    <p><?= $error ?></p>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Login</button>
    </form>
</div>
</body>
</html>
