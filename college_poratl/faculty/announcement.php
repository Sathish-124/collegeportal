<?php
session_start();
include '../includes/db.php';

if($_SESSION['user']['role'] != 'faculty'){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $title = $_POST['title'];
    $message = $_POST['message'];
    $faculty_id = $_SESSION['user']['id'];

    $stmt = $pdo->prepare(
        "INSERT INTO announcements (faculty_id, title, message)
         VALUES (?, ?, ?)"
    );
    $stmt->execute([$faculty_id, $title, $message]);

    echo "Announcement posted!";
}
?>

<form method="POST">
    <input name="title" placeholder="Announcement Title" required>
    <textarea name="message" placeholder="Message" required></textarea>
    <button>Post Announcement</button>
</form>
