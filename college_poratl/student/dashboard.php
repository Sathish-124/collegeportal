<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student'){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard-bg">
    <ul>
    <li><a href="view_attendance.php">View Attendance</a></li>
    <li><a href="view_marks.php">View Marks</a></li>
    <li><a href="view_announcement.php">View Announcement</a></li>
    <li><a href="view_syllabus.php">View Syllabus</a></li>
    <li><a href="feedback.php">Give Faculty Feedback</a></li>
    <li><a href="available_quizzes.php">Available Quiz</a></li>
     <li><a href="attempt_quiz.php">Attempt Quiz</a></li>

</ul>


<div class="container">
    <h2>Welcome Student: <?php echo $_SESSION['user']['name']; ?></h2>
    <p><strong>Department:</strong> <?php echo $_SESSION['user']['department']; ?></p>
    <a href="../logout.php">Logout</a>
</div>

</body>
</html>
