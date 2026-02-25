<?php
include '../includes/db.php';

$message = "";

// Fetch subjects
$subjects = $pdo->query("SELECT id, subject_name FROM subjects")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $selectedSubjects = $_POST['subjects']; // array

    // Insert faculty
    $stmt = $pdo->prepare(
        "INSERT INTO users (name, email, password, role, department)
         VALUES (?, ?, ?, 'faculty', ?)"
    );
    $stmt->execute([$name, $email, $password, $department]);

    $userId = $pdo->lastInsertId();

    // Insert subjects handled by faculty
    $map = $pdo->prepare(
        "INSERT INTO user_subjects (user_id, subject_id)
         VALUES (?, ?)"
    );

    foreach ($selectedSubjects as $subId) {
        $map->execute([$userId, $subId]);
    }

    $message = "Faculty registered with subjects successfully!";
}
?>

<form method="POST">
    <input name="name" placeholder="Faculty Name" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <input name="department" placeholder="Department" required>

    <label>Subjects Handled:</label>
    <select name="subjects[]" multiple required>
        <?php foreach ($subjects as $sub): ?>
            <option value="<?= $sub['id'] ?>">
                <?= $sub['subject_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button>Register Faculty</button>
</form>

<?= $message ?>
