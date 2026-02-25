<?php
session_start();
require_once '../includes/db.php';

// Security check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'faculty') {
    header("Location: login.php");
    exit;
}

$faculty_id = $_SESSION['user']['id'];
$message = "";

/* Fetch subjects handled by faculty */
$stmt = $pdo->prepare(
    "SELECT s.id, s.subject_name
     FROM subjects s
     JOIN user_subjects us ON s.id = us.subject_id
     WHERE us.user_id = ?"
);
$stmt->execute([$faculty_id]);
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $subject_id = $_POST['subject_id'];

    if (isset($_FILES['syllabus']) && $_FILES['syllabus']['error'] === 0) {

        $fileName = time() . "_" . basename($_FILES['syllabus']['name']);
        $targetPath = "../uploads/syllabus/" . $fileName;

        if (move_uploaded_file($_FILES['syllabus']['tmp_name'], $targetPath)) {

            $insert = $pdo->prepare(
                "INSERT INTO syllabus (subject_id, faculty_id, file_name)
                 VALUES (?, ?, ?)"
            );
            $insert->execute([$subject_id, $faculty_id, $fileName]);

            $message = "✅ Syllabus uploaded successfully!";
        } else {
            $message = "❌ File upload failed.";
        }
    } else {
        $message = "❌ Please select a syllabus file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Syllabus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard-bg">
<div class="container">

    <h2>Upload Syllabus</h2>
    <p><?= $message ?></p>

    <form method="POST" enctype="multipart/form-data">

        <label>Select Subject:</label>
        <select name="subject_id" required>
            <?php foreach ($subjects as $sub): ?>
                <option value="<?= $sub['id'] ?>">
                    <?= $sub['subject_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="file" name="syllabus" accept=".pdf,.doc,.docx" required>

        <button type="submit">Upload</button>
    </form>

    <br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</div>
</body>
</html>
