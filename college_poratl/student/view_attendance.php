<?php
session_start();
require_once '../includes/db.php';

// Security check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user']['id'];

/* Fetch attendance only for enrolled subjects */
$stmt = $pdo->prepare(
    "SELECT s.subject_name, a.date, a.status
     FROM attendance a
     JOIN subjects s ON a.subject_id = s.id
     JOIN user_subjects us ON us.subject_id = s.id
     WHERE a.student_id = ? AND us.user_id = ?
     ORDER BY a.date DESC"
);

$stmt->execute([$student_id, $student_id]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Attendance</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard-bg">

<div class="container">
    <h2>My Attendance</h2>

    <?php if ($stmt->rowCount() === 0): ?>
        <p>No attendance records found.</p>
    <?php else: ?>
        <table border="1" width="100%">
            <tr>
                <th>Subject</th>
                <th>Date</th>
                <th>Status</th>
            </tr>

            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $row['subject_name']; ?></td>
                    <td><?= $row['date']; ?></td>
                    <td><?= $row['status']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    <br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
