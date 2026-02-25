<?php
session_start();
require_once '../includes/db.php';

$student_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare(
    "SELECT q.id, q.title, s.subject_name
     FROM quizzes q
     JOIN subjects s ON q.subject_id = s.id
     JOIN user_subjects us ON us.subject_id = s.id
     WHERE us.user_id = ?"
);
$stmt->execute([$student_id]);
?>

<h2>Available Quizzes</h2>

<?php while ($row = $stmt->fetch()): ?>
    <p>
        <?= $row['title'] ?> (<?= $row['subject_name'] ?>)
        <a href="attempt_quiz.php?quiz_id=<?= $row['id'] ?>">Attempt</a>
    </p>
<?php endwhile; ?>
