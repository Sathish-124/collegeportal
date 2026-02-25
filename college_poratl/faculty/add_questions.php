<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare(
        "INSERT INTO quiz_questions
        (quiz_id, question, option_a, option_b, option_c, option_d, correct_option)
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    )->execute([
        $_POST['quiz_id'], $_POST['question'],
        $_POST['a'], $_POST['b'], $_POST['c'], $_POST['d'],
        $_POST['correct']
    ]);
}
?>

<form method="POST">
    <input name="quiz_id" placeholder="Quiz ID" required>
    <textarea name="question" placeholder="Question"></textarea>
    <input name="a" placeholder="Option A">
    <input name="b" placeholder="Option B">
    <input name="c" placeholder="Option C">
    <input name="d" placeholder="Option D">
    <input name="correct" placeholder="Correct Option (A/B/C/D)">
    <button>Add Question</button>
</form>
