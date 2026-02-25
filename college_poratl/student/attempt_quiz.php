<?php
session_start();
require_once '../includes/db.php';

$quiz_id = $_GET['quiz_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    foreach ($_POST['answers'] as $qid => $ans) {
        $stmt = $pdo->prepare(
            "SELECT correct_option FROM quiz_questions WHERE id=?"
        );
        $stmt->execute([$qid]);
        if ($stmt->fetchColumn() === $ans) $score++;
    }

    $pdo->prepare(
        "INSERT INTO quiz_results (quiz_id, student_id, score)
         VALUES (?, ?, ?)"
    )->execute([$quiz_id, $_SESSION['user']['id'], $score]);

    echo "Score: $score";
    exit;
}

$q = $pdo->prepare("SELECT * FROM quiz_questions WHERE quiz_id=?");
$q->execute([$quiz_id]);
?>

<form method="POST">
<?php while ($row = $q->fetch()): ?>
    <p><?= $row['question'] ?></p>
    <input type="radio" name="answers[<?= $row['id'] ?>]" value="A"> <?= $row['option_a'] ?><br>
    <input type="radio" name="answers[<?= $row['id'] ?>]" value="B"> <?= $row['option_b'] ?><br>
    <input type="radio" name="answers[<?= $row['id'] ?>]" value="C"> <?= $row['option_c'] ?><br>
    <input type="radio" name="answers[<?= $row['id'] ?>]" value="D"> <?= $row['option_d'] ?><br>
<?php endwhile; ?>
<button>Submit Quiz</button>
</form>
