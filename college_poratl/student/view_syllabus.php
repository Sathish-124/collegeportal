<?php
session_start();
require_once '../includes/db.php';

// Security check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user']['id'];

/* Fetch syllabus only for enrolled subjects */
$stmt = $pdo->prepare(
    "SELECT s.subject_name, sy.file_name, sy.uploaded_at
     FROM syllabus sy
     JOIN subjects s ON sy.subject_id = s.id
     JOIN user_subjects us ON us.subject_id = s.id
     WHERE us.user_id = ?
     ORDER BY sy.uploaded_at DESC"
);
$stmt->execute([$student_id]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Syllabus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard-bg">
<div class="container">

    <h2>My Syllabus</h2>

    <?php if ($stmt->rowCount() === 0): ?>
        <p>No syllabus uploaded yet.</p>
    <?php else: ?>
        <table border="1" width="100%">
            <tr>
                <th>Subject</th>
                <th>File</th>
                <th>Uploaded On</th>
            </tr>

            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $row['subject_name'] ?></td>
                    <td>
                        <a href="../uploads/syllabus/<?= $row['file_name'] ?>" target="_blank">
                            View / Download
                        </a>
                    </td>
                    <td><?= $row['uploaded_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    <br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</div>
</body>
</html>
