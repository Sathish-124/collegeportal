<?php
require_once '../includes/db.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $student_id = trim($_POST['student_id']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check student exists
    $checkStudent = $pdo->prepare(
        "SELECT id FROM users WHERE id = ? AND role = 'student'"
    );
    $checkStudent->execute([$student_id]);

    if ($checkStudent->rowCount() === 0) {
        $message = "❌ Invalid Student ID";
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO parents (name, email, password, student_id)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$name, $email, $password, $student_id]);
        $message = "✅ Parent registered successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Parent Registration</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-bg">

<div class="container">
    <h2>Parent Registration</h2>
    <p><?= $message ?></p>

    <form method="POST">
        <input name="name" placeholder="Parent Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input name="student_id" placeholder="Student ID" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Register</button>
    </form>

    <a href="login.php">Already registered? Login</a>
</div>
</body>
</html>
