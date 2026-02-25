<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'faculty'");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        session_regenerate_id(true); // session security
        $_SESSION['user'] = $user;

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Invalid faculty credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="login-bg">

<div class="container">
    <h2>Faculty Login</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Faculty Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</div>

</body>
</html>
