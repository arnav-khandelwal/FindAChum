<?php
session_start();
include 'db_connection.php'; // Include the database connection

// Check if user is logged in
if (empty($_SESSION['user_name'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_name = $_SESSION['user_name']; // Get the logged-in user's user_name from session

// Get the user_id of the logged-in user
$query = "SELECT id FROM users WHERE user_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user_name);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$user_id = $user_data['id'];

// Get the list of friends where the user is either the user_id or the friend_id, excluding the current user
$query = "SELECT u.user_name, u.id 
          FROM users u 
          JOIN friends f ON (f.user_id = u.id OR f.friend_id = u.id) 
          WHERE (f.user_id = ? OR f.friend_id = ?) 
            AND f.status = 'accepted'
            AND u.id != ?"; // Exclude the current user from the results

$stmt = $conn->prepare($query);
$stmt->bind_param('iii', $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user has any friends
if ($result->num_rows > 0) {
    $friends = [];
    while ($row = $result->fetch_assoc()) {
        $friends[] = $row;
    }
    echo json_encode(['success' => true, 'friends' => $friends]);
} else {
    echo json_encode(['success' => true, 'message' => 'No friends at the moment']);
}

$stmt->close();
?>
