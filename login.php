<?php
session_start();
include "includes/db.php";
include "includes/databaseFunction.php";
include "templates/login.html.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $msg = 'All fields are required.';
    } else {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        // Tìm kiếm username và password trong bảng
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $_SESSION['password'] =$password) {
                // Set session variables
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];

                if ($user['role'] === 1) {
                    header("Location: admin/admin.html.php");
                } else {
                    header("Location: login_success.php");
                }
                exit();
            } else {
                $msg = 'Invalid username or password.';
            }
        } else {
            $msg = "Database query failed: " . implode(", ", $stmt->errorInfo());
        }
    }
}
?>
