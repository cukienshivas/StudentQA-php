<?php
session_start();
include "includes/db.php";
include "templates/signup.html.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
        
        
    }

    // Validate username and password length
    if (strlen($username) < 3 || strlen($password) < 6) {
        $_SESSION['error'] = "Username must be at least 3 characters and password must be at least 6 characters.";
        
    }
    // Check if username already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetch()) {
        $_SESSION['error'] = "Username is already taken!";
        exit(); // Add exit() here
    } else {
        // Prepare to insert new user record
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Set session variables and redirect
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true;
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "An error occurred during signup. Please try again.";
            header("Location: signup.php");
            exit(); // Add exit() here
        }
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    // header("Location: signup.php");
    exit(); // Add exit() here
}
