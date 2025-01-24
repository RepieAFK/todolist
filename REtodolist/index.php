<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: isi.php');
        } else {
            echo 'Login failed';
        }
    } elseif (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        $stmt->execute([$username, $password]);

        header('Location: isi.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="w.css">
    <title>Authentication</title>
</head>
<body>
    <div class="container">
        <div class="auth-forms">
            <input type="radio" name="auth-tab" id="login-tab" checked>
            <label for="login-tab">Login</label>
            <input type="radio" name="auth-tab" id="register-tab">
            <label for="register-tab">Register</label>
            <div class="form-container">
                <form id="login-form" method="POST">
                    <h2>Login</h2>
                    <label>Username:</label>
                    <input type="text" name="username" required><br>
                    <label>Password:</label>
                    <input type="password" name="password" required><br>
                    <button type="submit" name="login">Login</button>
                </form>
                <form id="register-form" method="POST">
                    <h2>Register</h2>
                    <label>Username:</label>
                    <input type="text" name="username" required><br>
                    <label>Password:</label>
                    <input type="password" name="password" required><br>
                    <button type="submit" name="register">Register</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
