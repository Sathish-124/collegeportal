<?php
session_start();
require_once '../includes/db.php';

$stmt = $pdo->prepare(
    "SELECT rating, comments, created_at
     FROM feedback WHERE faculty_id=?"
);
$stmt->execute([$_SESSION['user']['id']]);

while ($row = $stmt->fetch()) {
    echo "Rating: {$row['rating']}<br>";
    echo "Comment: {$row['comments']}<hr>";
}
