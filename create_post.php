<?php
require 'db_connection.php';

// Start the session to use session variables
session_start();

// Check if the connection was established successfully
if (!$conn) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$userId = $_SESSION['user_id']; 

// Check if the form data is sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form data exists in the POST array
    $title = isset($_POST['postTitle']) ? mysqli_real_escape_string($conn, $_POST['postTitle']) : '';
    $tags = isset($_POST['postTags']) ? mysqli_real_escape_string($conn, $_POST['postTags']) : '';
    $content = isset($_POST['postContent']) ? mysqli_real_escape_string($conn, $_POST['postContent']) : '';
    $playTime = isset($_POST['timing']) ? mysqli_real_escape_string($conn, $_POST['timing']) : '';

    // Debugging: print the received POST data
    error_log("Received data: Title = $title, Content = $content, Tags = $tags, Play Time = $playTime");

    // Check if the title and content are non-empty
    if (empty($title) || empty($content)) {
        echo json_encode(['error' => 'Title and content are required']);
        exit;
    }

    // Use a dummy user_id for testing if $_SESSION['user_id'] is not set
    $user_id = $_SESSION['user_id'] ?? 1; // Replace 1 with the actual fallback user ID

    // Insert the new post into the database
    $query = "INSERT INTO posts (title, tags, content, play_time, user_id) 
              VALUES ('$title', '$tags', '$content', '$playTime', $user_id)";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Post created successfully']);
    } else {
        echo json_encode(['error' => 'Error creating post: ' . mysqli_error($conn)]);
    }
}

// Close the database connection
mysqli_close($conn);
?>
