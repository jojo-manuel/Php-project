<?php
// delete_post.php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the post ID from the URL
$post_id = $_GET['id'];

// Check if the post exists and belongs to the logged-in user
$sql = "SELECT * FROM posts WHERE id = $post_id";
$result = $conn->query($sql);
$post = $result->fetch_assoc();

if ($post && $post['author_id'] == $_SESSION['user_id']) {
    // Delete the post
    $sql_delete = "DELETE FROM posts WHERE id = $post_id";
    if ($conn->query($sql_delete) === TRUE) {
        $_SESSION['message'] = "Post deleted successfully!";
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['error'] = "Error deleting post.";
    }
} else {
    $_SESSION['error'] = "You do not have permission to delete this post.";
    header('Location: index.php');
    exit();
}
?>
