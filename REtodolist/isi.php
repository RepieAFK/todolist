<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM tasks WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$tasks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ow.css">
    <title>To-Do List</title>
</head>
<body>
    <div class="container">
        <h2>To-Do List</h2>
        <a href="task.php?action=add">Add Task</a>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <?php echo htmlspecialchars($task['title']); ?>
                    <a href="task.php?action=edit&id=<?php echo $task['id']; ?>">Edit</a>
                    <a href="task.php?action=delete&id=<?php echo $task['id']; ?>">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
