<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$action = $_GET['action'];

if ($action == 'add' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare('INSERT INTO tasks (user_id, title, description) VALUES (?, ?, ?)');
    $stmt->execute([$_SESSION['user_id'], $title, $description]);

    header('Location: isi.php');
} elseif ($action == 'edit' && isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare('UPDATE tasks SET title = ?, description = ? WHERE id = ? AND user_id = ?');
    $stmt->execute([$title, $description, $id, $_SESSION['user_id']]);

    header('Location: isi.php');
} elseif ($action == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');
    $stmt->execute([$id, $_SESSION['user_id']]);

    header('Location: isi.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="wow.css">
    <title>Manage Task</title>
</head>
<body>
    <div class="container">
        <?php if ($action == 'add' || ($action == 'edit' && isset($_GET['id']))): ?>
            <form method="POST">
                <h2><?php echo $action == 'add' ? 'Add Task' : 'Edit Task'; ?></h2>
                <label>Title:</label>
                <input type="text" name="title" value="<?php echo $task['title'] ?? ''; ?>" required><br>
                <label>Description:</label>
                <textarea name="description" required><?php echo $task['description'] ?? ''; ?></textarea><br>
                <button type="submit"><?php echo $action == 'add' ? 'Add' : 'Update'; ?> Task</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
