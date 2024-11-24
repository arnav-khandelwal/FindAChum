<?php
require 'db_connection.php';

// Check if the connection was established successfully
if (!$conn) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$query = "SELECT * FROM posts ORDER BY play_time DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['error' => 'Failed to fetch posts: ' . mysqli_error($conn)]);
    exit;
}

$posts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $posts[] = $row;
}

// Return posts as JSON
echo json_encode($posts);

// Close the database connection
mysqli_close($conn);
?>
