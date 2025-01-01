<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Include the database connection
include('db.php');

// Handle form submission for creating a new post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $username = $_SESSION['username']; // The logged-in user's username

    // Ensure the title and content are not empty
    if (!empty($title) && !empty($content)) {
        // Insert post into the database
        $stmt = $conn->prepare("INSERT INTO posts (title, content, username) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $username);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Post created successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Title and content cannot be empty.</div>";
    }
}
// Handle form submission for creating a new post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $username = $_SESSION['username']; // The logged-in user's username

    // Ensure the title and content are not empty
    if (!empty($title) && !empty($content)) {
        // Insert post into the database
        $stmt = $conn->prepare("INSERT INTO posts (title, content, username) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $username); // Bind parameters to the query

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Post created successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Title and content cannot be empty.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Welcome, <?php echo $_SESSION['username']; ?>!</h2>

    <!-- Post creation form -->
    <h3>Create a New Post</h3>
    <form action="index.php" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Post Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Post Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="submit_post">Create Post</button>
    </form>

    <!-- Display existing posts -->
    <h3 class="mt-5">Existing Posts</h3>
    <?php
    // Fetch posts from the database
    $result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
            echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
            echo "<small>Posted by " . htmlspecialchars($row['username']) . " on " . $row['created_at'] . "</small>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>No posts yet.</p>";
    }
    ?>

    <p><a href="logout.php" class="btn btn-danger">Logout</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
