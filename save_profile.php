<?php
session_start();
include 'db_connection.php'; // Replace with your database connection file

// User identification
$user_name = $_SESSION['user_name'];

// Initialize updates array and image path variable
$updates = [];
$image_path = "";

// Handle image upload if a file is provided
if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
    $fileTmpPath = $_FILES["profile_picture"]["tmp_name"];
    $fileName = $_FILES["profile_picture"]["name"];
    $fileSize = $_FILES["profile_picture"]["size"];
    $fileType = $_FILES["profile_picture"]["type"];
    
    // Allow only image files
    $allowedMimeTypes = ["image/jpeg", "image/png", "image/gif"];
    if (in_array($fileType, $allowedMimeTypes)) {
        $targetDir = "images/"; // Folder to store images
        $targetFile = $targetDir . basename($fileName); // Full file path

        // Attempt to move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpPath, $targetFile)) {
            $image_path = $targetFile; // Set the image path for saving in DB
            $updates[] = "image_address = '" . mysqli_real_escape_string($conn, $image_path) . "'";
        } else {
            echo json_encode(['success' => false, 'message' => 'Error uploading the image.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Only image files are allowed.']);
        exit;
    }
}

// Process the other profile fields (bio, interests, etc.) from the POST data
if (isset($_POST['bio']) && !empty($_POST['bio'])) {
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $updates[] = "bio = '$bio'";
}
if (isset($_POST['interests']) && !empty($_POST['interests'])) {
    $interests = mysqli_real_escape_string($conn, $_POST['interests']);
    $updates[] = "interests = '$interests'";
}
if (isset($_POST['location']) && !empty($_POST['location'])) {
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $updates[] = "location = '$location'";
}
if (isset($_POST['age']) && !empty($_POST['age'])) {
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $updates[] = "age = '$age'";
}
if (isset($_POST['instagram']) && !empty($_POST['instagram'])) {
    $instagram = mysqli_real_escape_string($conn, $_POST['instagram']);
    $updates[] = "instagram = '$instagram'";
}
if (isset($_POST['twitter']) && !empty($_POST['twitter'])) {
    $twitter = mysqli_real_escape_string($conn, $_POST['twitter']);
    $updates[] = "twitter = '$twitter'";
}

// If there are updates, execute the SQL update query
if (count($updates) > 0) {
    $sql = "UPDATE user_info SET " . implode(', ', $updates) . " WHERE user_name = '$user_name'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(['success' => true]);
        $_SESSION['image_address'] = "images/$fileName"; 
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No data to update.']);
}
?>
