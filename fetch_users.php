<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT users.user_name, user_info.image_address FROM users 
              JOIN user_info ON users.user_name = user_info.user_name";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode($users);
    } else {
        echo json_encode([]);
    }
}
?>
