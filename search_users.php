<?php
session_start();
include 'db_connection.php';

if (empty($_SESSION['user_name'])) {
    echo json_encode(['users' => []]);
    exit;
}

$user_name = $_SESSION['user_name'];
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Update the SQL query to fetch image_address from user_info as well
$sql = "SELECT u.user_name, u.image_address, 
            EXISTS (SELECT 1 FROM friends f
                    WHERE f.user_id = (SELECT id FROM users WHERE user_name = ?) 
                    AND f.friend_id = (SELECT id FROM users WHERE user_name = u.user_name) 
                    AND f.status = 'accepted') AS isFriend
        FROM user_info u
        WHERE u.user_name LIKE ? AND u.user_name != ?";
$stmt = $conn->prepare($sql);
$likeQuery = "%$query%";
$stmt->bind_param('sss', $user_name, $likeQuery, $user_name);
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode(['users' => $users]);
?>
