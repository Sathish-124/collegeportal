<?php
require_once '../includes/db.php';

$message = "";

// Fetch all subjects
$stmt = $pdo->query("SELECT id, subject_name FROM subjects");
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $department = trim($_POST['department']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Validate subjects
    if (!isset($_POST['subjects']) || !is_array($_POST['subjects'])) {
        $message = "❌ Please select at least one subject.";
    } else {

        // Check if email already exists
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            $message = "❌ Email already registered.";
        } else {

            // Insert student into users table
            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email, password, role, department)
                 VALUES (?, ?, ?, 'student', ?)"
            );
            $stmt->execute([$name, $email, $password, $department]);

            // Get inserted student ID
            $userId = $pdo->lastInsertId();

            // Insert selected subjects into user_subjects table
            $map = $pdo->prepare(
                "INSERT INTO user_subjects (user_id, subject_id)
                 VALUES (?, ?)"
            );

            foreach ($_POST['subjects'] as $subject_id) {
                $map->execute([$userId, $subject_id]);
            }

            $message = "✅ Student registered successfully!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="login-bg">

<div class="container">
    <h2>Student Registration</h2>

    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST">

        <input type="text" name="name" placeholder="Student Name" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <input type="text" name="department" placeholder="Department" required>

        <label><strong>Select Subjects:</strong></label><br><br>

        <?php foreach ($subjects as $sub): ?>
            <label>
                <input type="checkbox" name="subjects[]" value="<?php echo $sub['id']; ?>">
                <?php echo $sub['subject_name']; ?>
            </label><br>
        <?php endforeach; ?>

        <br>
        <button type="submit">Register Student</button>
    </form>

    <br>
    <a href="../index.php">⬅ Back to Home</a>
</div>

</body>
</html>
