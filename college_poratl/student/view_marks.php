<?php
session_start();
include '../includes/db.php';

// Security check
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student'){
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare(
    "SELECT s.subject_name, m.marks
     FROM marks m
     JOIN subjects s ON m.subject_id = s.id
     JOIN user_subjects us ON us.subject_id = s.id
     WHERE m.student_id = ? AND us.user_id = ?"
);

$stmt->execute([$student_id, $student_id]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Marks</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard-bg">

<div class="container">
    <h2>My Marks</h2>

    <?php
    if ($stmt->rowCount() === 0) {
        echo "<p>No marks available yet.</p>";
    } else {
        echo "<table border='1' width='100%'>";
        echo "<tr><th>Subject</th><th>Marks</th></tr>";

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<tr>
                    <td>{$row['subject_name']}</td>
                    <td>{$row['marks']}</td>
                  </tr>";
        }

        echo "</table>";
    }
    ?>

    <br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
