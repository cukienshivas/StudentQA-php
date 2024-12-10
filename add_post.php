<?php
session_start();

// CSRF Token Setup
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
}

require 'includes/db.php'; 
require 'includes/databasefunction.php';   

// Handle Request
$message = null;
$data = addpost($pdo, $message);
$modules = $data['modules'];

// Redirect on Success
if ($message === 'POST added successfully') {
    header("Location: index.php");
    exit();
}

// Template Setup
$title = "Add Post";
require "templates/add_post.html.php";
