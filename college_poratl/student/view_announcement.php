<?php
session_start();
require_once '../includes/db.php';

// Security check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Announcements</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard-bg">

<div class="container">
    <h2>Announcements</h2>

    <?php
    // Fetch announcements with faculty name
    $stmt = $pdo->query(
        "SELECT a.title, a.message, a.created_at, u.name AS faculty_name
         FROM announcements a
         JOIN users u ON a.faculty_id = u.id
         ORDER BY a.created_at DESC"
    );

    if ($stmt->rowCount() === 0) {
        echo "<p>No announcements available.</p>";
    } else {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "
                <div style='margin-bottom:15px; padding:10px; border-bottom:1px solid #ccc;'>
                    <h3>{$row['title']}</h3>
                    <p>{$row['message']}</p>
                    <small>
                        Posted by {$row['faculty_name']} on {$row['created_at']}
                    </small>
                </div>
            ";
        }
    }
    ?>

    <br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
