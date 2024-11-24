<?php
session_start();
include 'db_connection.php'; // Include your database connection

// Check if user is logged in
if (empty($_SESSION['user_name'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_name = $_SESSION['user_name']; // Get the logged-in user's user_name from session
$data = json_decode(file_get_contents('php://input'), true); // Get the friend_user_name from the request body
$friend_user_name = $data['friend_user_name'];

// Check if the friend exists
$query = "SELECT user_name FROM user_info WHERE user_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $friend_user_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Friend not found']);
    exit;
}

// Get the user_id of the logged-in user
$query = "SELECT id FROM users WHERE user_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user_name);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$user_id = $user_data['id'];

// Get the user_id of the friend
$query = "SELECT id FROM users WHERE user_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $friend_user_name);
$stmt->execute();
$result = $stmt->get_result();
$friend_data = $result->fetch_assoc();
$friend_id = $friend_data['id'];

// Insert a friend request into the 'friends' table with status 'pending'
$query = "INSERT INTO friends (user_id, friend_id, status) VALUES (?, ?, 'accepted')";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $user_id, $friend_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Friend request sent']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send friend request']);
}

$stmt->close();
?>
