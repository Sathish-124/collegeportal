<?php
session_start();

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'faculty'){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard-bg">
    <ul>
    <li><a href="attendance.php">Mark Attendance</a></li>
    <li><a href="marks.php">Enter Marks</a></li>
    <li><a href="announcement.php">Post Announcement</a></li>
    <li><a href="upload_syllabus.php">Upload Syllabus</a></li>
     <li><a href="create_quiz.php">Create Quiz</a></li>
    <li><a href="add_questions.php">Add Quiz Questions</a></li>
    <li><a href="view_feedback.php">View Student Feedback</a></li>
<li><a href="manage_syllabus.php">Manage Syllabus</a></li>


</ul>


<div class="container">
    <h2>Welcome Faculty: <?php echo $_SESSION['user']['name']; ?></h2>
    <p><strong>Department:</strong> <?php echo $_SESSION['user']['department']; ?></p>

    <ul>
        <li>Post Announcements</li>
        <li>Upload Notes</li>
        <li>View Students</li>
    </ul>

    <a href="../logout.php">Logout</a>
</div>

</body>
</html>
