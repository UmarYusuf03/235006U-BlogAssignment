<?php
// Include helper functions and database connection
require_once 'functions.php';

// Check if user is logged in
// If not, redirect them to login page
if (!isLoggedIn()) {
    header('Location: ./login.php');
    exit; 
}

// Get the post ID from the URL query string
$id = $_GET['id'] ?? null;

// If no ID is given in the URL, send user back to homepage
if (!$id) {
    header('Location: ./index.php');
    exit;
}

// Retrieve the post data from the database using the ID
$post = getPost($id);

// If the post doesn’t exist, show a message and stop
if (!$post) {
    echo 'Post not found';
    exit;
}

// Security check: make sure the logged-in user owns this post
// Only the person who created it can delete it
if (currentUserId() != $post['user_id']) {
    echo 'Unauthorized';
    exit;
}

// If all checks pass, delete the post from the database
deletePost($id);

// After deletion, redirect the user back to the homepage
header('Location: index.php');
exit;
