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

// Remove friend from friends table
$query = "DELETE FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('iiii', $user_id, $friend_id, $friend_id, $user_id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
