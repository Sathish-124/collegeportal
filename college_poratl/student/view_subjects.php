<?php
session_start();
include '../includes/db.php';

// Security check
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student'){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare(
    "SELECT s.subject_name
     FROM subjects s
     JOIN user_subjects us ON s.id = us.subject_id
     WHERE us.user_id = ?"
);
$stmt->execute([$user_id]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Subjects</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard-bg">

<div class="container">
    <h2>My Enrolled Subjects</h2>

    <?php
    if ($stmt->rowCount() === 0) {
        echo "<p>No subjects enrolled.</p>";
    } else {
        echo "<ul>";
        while($row = $stmt->fetch()){
            echo "<li>📘 {$row['subject_name']}</li>";
        }
        echo "</ul>";
    }
    ?>

    <a href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
