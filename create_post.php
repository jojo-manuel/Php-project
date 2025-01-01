<?php
// create_post.php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id'];

    $sql = "INSERT INTO posts (title, content, author_id) VALUES ('$title', '$content', '$author_id')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Post created successfully!";
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
    }
}
?>
