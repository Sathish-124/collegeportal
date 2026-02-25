<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'faculty') {
    header("Location: login.php");
    exit;
}

$faculty_id = $_SESSION['user']['id'];

/* DELETE syllabus */
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $stmt = $pdo->prepare(
        "SELECT file_name FROM syllabus 
         WHERE id = ? AND faculty_id = ?"
    );
    $stmt->execute([$id, $faculty_id]);
    $file = $stmt->fetch();

    if ($file) {
        unlink("../uploads/syllabus/" . $file['file_name']);

        $pdo->prepare(
            "DELETE FROM syllabus WHERE id = ?"
        )->execute([$id]);
    }

    header("Location: manage_syllabus.php");
    exit;
}

/* FETCH syllabus */
$stmt = $pdo->prepare(
    "SELECT sy.id, s.subject_name, sy.file_name, sy.uploaded_at
     FROM syllabus sy
     JOIN subjects s ON sy.subject_id = s.id
     WHERE sy.faculty_id = ?
     ORDER BY sy.uploaded_at DESC"
);
$stmt->execute([$faculty_id]);
$syllabus = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Syllabus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dashboard-bg">

<div class="container">
    <h2>Manage Syllabus</h2>

    <table border="1" width="100%">
        <tr>
            <th>Subject</th>
            <th>File</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($syllabus as $row): ?>
        <tr>
            <td><?= $row['subject_name'] ?></td>
            <td>
                <a href="../uploads/syllabus/<?= $row['file_name'] ?>" target="_blank">
                    View
                </a>
            </td>
            <td>
                <a href="edit_syllabus.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="?delete=<?= $row['id'] ?>" 
                   onclick="return confirm('Delete syllabus?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="dashboard.php">⬅ Back</a>
</div>
</body>
</html>
