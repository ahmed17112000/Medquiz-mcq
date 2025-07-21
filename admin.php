<?php
// admin.php - Admin Dashboard

session_start();

// Dummy authentication check
// In real implementation, check if the user is an admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Connect to database
$conn = new mysqli("localhost", "root", "", "medical_questions");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users
$users_result = $conn->query("SELECT * FROM users");

// Fetch questions
$questions_result = $conn->query("SELECT * FROM questions");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; padding: 20px; }
        h2 { color: #007b8a; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #007b8a; color: white; }
        a { color: #007b8a; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<h2>Admin Dashboard</h2>

<h3>Users</h3>
<table>
    <tr>
        <th>ID</th><th>Username</th><th>Email</th><th>Actions</th>
    </tr>
    <?php while($user = $users_result->fetch_assoc()): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= $user['username'] ?></td>
        <td><?= $user['email'] ?></td>
        <td>
            <a href="edit_user.php?id=<?= $user['id'] ?>">Edit</a> |
            <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h3>Questions</h3>
<table>
    <tr>
        <th>ID</th><th>Title</th><th>Subject</th><th>Actions</th>
    </tr>
    <?php while($q = $questions_result->fetch_assoc()): ?>
    <tr>
        <td><?= $q['id'] ?></td>
        <td><?= $q['title'] ?></td>
        <td><?= $q['subject'] ?></td>
        <td>
            <a href="edit_question.php?id=<?= $q['id'] ?>">Edit</a> |
            <a href="delete_question.php?id=<?= $q['id'] ?>" onclick="return confirm('Delete this question?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
