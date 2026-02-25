<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'faculty') {
    header("Location: login.php");
    exit;
}

$faculty_id = $_SESSION['user']['id'];
$id = $_GET['id'];

/* Fetch syllabus */
$stmt = $pdo->prepare(
    "SELECT * FROM syllabus WHERE id = ? AND faculty_id = ?"
);
$stmt->execute([$id, $faculty_id]);
$syllabus = $stmt->fetch();

if (!$syllabus) {
    die("Unauthorized access");
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_FILES['syllabus']['error'] === 0) {

        unlink("../uploads/syllabus/" . $syllabus['file_name']);

        $newFile = time() . "_" . $_FILES['syllabus']['name'];
        move_uploaded_file(
            $_FILES['syllabus']['tmp_name'],
            "../uploads/syllabus/" . $newFile
        );

        $pdo->prepare(
            "UPDATE syllabus SET file_name = ?, uploaded_at = NOW()
             WHERE id = ?"
        )->execute([$newFile, $id]);

        $message = "✅ Syllabus updated successfully";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Syllabus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dashboard-bg">

<div class="container">
    <h2>Edit Syllabus</h2>
    <p><?= $message ?></p>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="syllabus" required>
        <button>Update Syllabus</button>
    </form>

    <br>
    <a href="manage_syllabus.php">⬅ Back</a>
</div>
</body>
</html>
