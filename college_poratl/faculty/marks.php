<?php
session_start();
require_once '../includes/db.php';

// Security check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'faculty') {
    header("Location: login.php");
    exit;
}

$faculty_id = $_SESSION['user']['id'];

/* Fetch subjects handled by faculty */
$subjectsStmt = $pdo->prepare(
    "SELECT s.id, s.subject_name
     FROM subjects s
     JOIN user_subjects us ON s.id = us.subject_id
     WHERE us.user_id = ?"
);
$subjectsStmt->execute([$faculty_id]);
$subjects = $subjectsStmt->fetchAll(PDO::FETCH_ASSOC);

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $marks = $_POST['marks'];

    $stmt = $pdo->prepare(
        "INSERT INTO marks (student_id, subject_id, marks)
         VALUES (?, ?, ?)"
    );
    $stmt->execute([$student_id, $subject_id, $marks]);

    $message = "✅ Marks entered successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enter Marks</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard-bg">

<div class="container">
    <h2>Enter Marks</h2>

    <?php if ($message) echo "<p>$message</p>"; ?>

    <form method="POST">
        <input type="number" name="student_id" placeholder="Student ID" required>

        <label>Select Subject:</label>
        <select name="subject_id" required>
            <?php foreach ($subjects as $sub): ?>
                <option value="<?= $sub['id']; ?>">
                    <?= $sub['subject_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="number" name="marks" placeholder="Marks" required>

        <button type="submit">Submit Marks</button>
    </form>

    <br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
