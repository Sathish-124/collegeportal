<?php
session_start();
require_once '../includes/db.php';

// Security check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'faculty') {
    header("Location: login.php");
    exit;
}

$faculty_id = $_SESSION['user']['id'];

/* Fetch subjects handled by this faculty */
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
    $status = $_POST['status'];

    $stmt = $pdo->prepare(
        "INSERT INTO attendance (student_id, subject_id, date, status)
         VALUES (?, ?, CURDATE(), ?)"
    );
    $stmt->execute([$student_id, $subject_id, $status]);

    $message = "✅ Attendance marked successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard-bg">

<div class="container">
    <h2>Mark Attendance</h2>

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

        <label>Status:</label>
        <select name="status" required>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
        </select>

        <button type="submit">Submit Attendance</button>
    </form>

    <br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
