<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare(
        "INSERT INTO feedback
        (student_id, faculty_id, subject_id, rating, comments)
        VALUES (?, ?, ?, ?, ?)"
    )->execute([
        $_SESSION['user']['id'],
        $_POST['faculty_id'],
        $_POST['subject_id'],
        $_POST['rating'],
        $_POST['comments']
    ]);
    echo "Feedback submitted";
}
?>

<form method="POST">
    <input name="faculty_id" placeholder="Faculty ID">
    <input name="subject_id" placeholder="Subject ID">
    <input name="rating" placeholder="Rating (1–5)">
    <textarea name="comments"></textarea>
    <button>Submit Feedback</button>
</form>
