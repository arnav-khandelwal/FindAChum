<?php
session_start();
include 'db_connection.php'; // Replace with your database connection file

$data = json_decode(file_get_contents('php://input'), true);
$user_name = $_SESSION['user_name'];

$updates = [];
foreach ($data as $column => $value) {
    if (!empty($value)) {
        $updates[] = "$column = '" . mysqli_real_escape_string($conn, $value) . "'";
    }
}

if (count($updates) > 0) {
    $sql = "UPDATE user_info SET " . implode(', ', $updates) . " WHERE user_name = '$user_name'";
    $result = mysqli_query($conn, $sql);

    echo json_encode(['success' => $result ? true : false]);
} else {
    echo json_encode(['success' => false]);
}
?>
