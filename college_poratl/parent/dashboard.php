<?php
session_start();
require_once '../includes/db.php';

/* Security check */
if (!isset($_SESSION['parent'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['parent']['student_id'];

/* Attendance */
$a = $pdo->prepare(
    "SELECT COUNT(*) AS total,
     SUM(status='Present') AS present
     FROM attendance WHERE student_id=?"
);
$a->execute([$student_id]);
$att = $a->fetch(PDO::FETCH_ASSOC);

$total = $att['total'] ?? 0;
$present = $att['present'] ?? 0;
$percentage = ($total > 0) ? round(($present / $total) * 100) : 0;

/* Marks */
$m = $pdo->prepare(
    "SELECT s.subject_name, m.marks
     FROM marks m
     JOIN subjects s ON m.subject_id=s.id
     WHERE m.student_id=?"
);
$m->execute([$student_id]);

/* Quiz */
$q = $pdo->prepare(
    "SELECT q.title, r.score
     FROM quiz_results r
     JOIN quizzes q ON r.quiz_id=q.id
     WHERE r.student_id=?"
);
$q->execute([$student_id]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Parent Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="parent-bg">

<div class="container">

    <h2>Parent Dashboard</h2>

    <!-- Attendance Section -->
    <h3>📅 Attendance Overview</h3>
    <p><strong>Attendance Percentage:</strong> <?= $percentage ?>%</p>

    <hr>

    <!-- Marks Section -->
    <h3>📘 Marks Summary</h3>
    <?php if ($m->rowCount() > 0): ?>
        <?php while ($row = $m->fetch(PDO::FETCH_ASSOC)): ?>
            <p><?= $row['subject_name']; ?> : <strong><?= $row['marks']; ?></strong></p>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No marks available.</p>
    <?php endif; ?>

    <hr>

    <!-- Quiz Section -->
    <h3>📝 Quiz Performance</h3>
    <?php if ($q->rowCount() > 0): ?>
        <?php while ($row = $q->fetch(PDO::FETCH_ASSOC)): ?>
            <p><?= $row['title']; ?> : <strong><?= $row['score']; ?></strong></p>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No quiz records available.</p>
    <?php endif; ?>

    <br>
    <a href="../logout.php">Logout</a>

</div>

</body>
</html>
