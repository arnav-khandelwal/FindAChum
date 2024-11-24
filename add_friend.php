<?php
session_start();
include 'db_connection.php';

if (empty($_SESSION['user_name'])) {
    echo json_encode(['success' => false]);
    exit;
}

$user_name = $_SESSION['user_name'];
$data = json_decode(file_get_contents('php://input'), true);
$friend_id = $data['friend_id'];

// Get user_id
$query = "SELECT id FROM user_info WHERE user_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user_name);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$user_id = $user_data['id'];

// Insert friend request into friends table
$query = "INSERT INTO friends (user_id, friend_id, status) VALUES (?, ?, 'pending')";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $user_id, $friend_id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
