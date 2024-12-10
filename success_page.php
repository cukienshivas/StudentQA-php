<?php
session_start();
if (empty($_SESSION['success'])) {
    header("Location: contact.php"); // Redirect back to form if accessed directly
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/contact.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
</head>
<body>
    <h2>Message Sent</h2>
    <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <a href="index.php">Go Back</a>
</body>
</html>
