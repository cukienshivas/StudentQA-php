<?php
session_start();
ob_start(); // Start output buffering

require_once 'includes/db.php';
require_once 'includes/databasefunction.php';



$searchQuery = filter_input(INPUT_GET, 'searchQuery');

// Fetch posts from the database
$posts = fetch_post($pdo);

// Ensure CSRF token exists
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flaming Student Q&A Platform - Homepage</title>
    <script src="js/oldflaming.js" defer></script>
</head>
<body>
    <h1>Welcome to the Homepage</h1>
   

<div class="search">
        <i class="fas fa-magnifying-glass" style="margin-right: auto; position: absolute; color: grey"></i>
        <input type="text" id="searchInput" placeholder="Search posts...">
        <button id="searchButton">Search</button>
    </div>
    <div id="searchResults">
    <?php
    if (!empty($_GET['searchQuery'])) {
        // Get the search query from the form
        $searchQuery = filter_input(INPUT_GET, 'searchQuery');

        // Call the searchPosts function and display results
        $searchResults = searchPosts($pdo, $searchQuery);
        if ($searchResults && count($searchResults) > 0) {
            foreach ($searchResults as $post) {
                echo "<div>";
                echo "<h3>" . htmlspecialchars($post['title'], ENT_QUOTES) . "</h3>";
                echo "<p>" . htmlspecialchars($post['content'], ENT_QUOTES) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No posts found matching your query.</p>";
        }
    }
    ?>
    </div>


    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
        <p>You are logged in as an admin.</p>
        <?php 
        if (filter_input(INPUT_GET, 'logout', FILTER_VALIDATE_BOOLEAN)) {
            session_unset();
            session_destroy();
            header("Location: login.php");
            exit();
        } ?>
        <a href="index.php?logout=true">Logout</a> 
    <?php else: ?>
        <a class="btnLogin-popup" href="login.php">Login</a> 
        <a class="btnLogin-popup" href="signup.php">Signup</a>
    <?php endif; ?>

    <div class="container my-5">
        <h2>All Posts</h2>
        <?php 
        if ($posts && count($posts) > 0) {
            displayPosts($posts);
        } else {
            echo "<p>No posts found.</p>";
        }
        ?>
    </div>
    <script src="js/flaming.js"></script>
</body>
</html>

<?php
$output = ob_get_clean(); // Capture the page content
include "templates/layout.html.php"; // Include layout template
?>
