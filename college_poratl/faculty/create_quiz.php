<?php
session_start();
require_once '../includes/db.php';

if ($_SESSION['user']['role'] !== 'faculty') exit;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare(
        "INSERT INTO quizzes (subject_id, faculty_id, title)
         VALUES (?, ?, ?)"
    )->execute([
        $_POST['subject_id'],
        $_SESSION['user']['id'],
        $_POST['title']
    ]);
    echo "Quiz created";
}
?>

<form method="POST">
    <input name="title" placeholder="Quiz Title" required>
    <input name="subject_id" placeholder="Subject ID" required>
    <button>Create Quiz</button>
</form>
