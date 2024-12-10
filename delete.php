<?php
include "includes/databasefunction.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$message = "";

if ($id) {
   
    $result = deletePost($id);
    $message = $result ? "Record deleted successfully." : "Failed to delete record.";
} else {
    $message = "Invalid ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Record</title>
</head>
<body>
    <p><?php echo htmlspecialchars($message); ?></p>
    <?php header("location:index.php") ?>
</body>
</html>
