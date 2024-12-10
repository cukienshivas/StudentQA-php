<?php
session_start();
include "includes/databaseFunction.php";

$name = $email = $message = $gender = "";
$nameErr = $emailErr = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [];

   
    // Validate Email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $errors[] = $emailErr;
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $errors[] = $emailErr;
        }
    }

    // Get Message and Gender (optional)
    $message = !empty($_POST["message"]) ? htmlspecialchars(trim($_POST["message"])) : "";
    $gender = !empty($_POST["gender"]) ? htmlspecialchars(trim($_POST["gender"])) : "";

    // Process Form Submission
    if (empty($errors)) {
        contactAdmin($pdo); 
        $_SESSION['success'] = "Your message has been sent successfully!";
        header("Location: success_page.php"); // Redirect to success page
        exit;
    }
}

// Include the form template
include 'templates/contact_form.html.php';
