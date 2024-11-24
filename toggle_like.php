<?php
// Include the database connection
include 'db_connection.php';

// Start the session to get the user ID (or retrieve it from your login system)
session_start();

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);

// Check if the postId, isLike, and userId are received
if (isset($data['postId']) && isset($data['isLike']) && isset($data['userId'])) {
    $postId = $data['postId'];
    $isLike = $data['isLike']; // true for like, false for unlike
    $userId = $data['userId'];

    // Check if the user has already liked the post
    $query = "SELECT * FROM post_likes WHERE post_id = ? AND user_id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'ii', $postId, $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // The user has already liked this post, so we remove the like
            if ($isLike) {
                // User is attempting to like it again (which shouldn't happen)
                echo json_encode(['error' => 'You already liked this post']);
                exit;
            }
            
            // Remove the like
            $deleteQuery = "DELETE FROM post_likes WHERE post_id = ? AND user_id = ?";
            if ($deleteStmt = mysqli_prepare($conn, $deleteQuery)) {
                mysqli_stmt_bind_param($deleteStmt, 'ii', $postId, $userId);
                mysqli_stmt_execute($deleteStmt);

                // Decrease the likes count
                $updateQuery = "UPDATE posts SET likes = likes - 1 WHERE id = ?";
                if ($updateStmt = mysqli_prepare($conn, $updateQuery)) {
                    mysqli_stmt_bind_param($updateStmt, 'i', $postId);
                    mysqli_stmt_execute($updateStmt);

                    // Get updated likes count
                    $likeCountResult = mysqli_query($conn, "SELECT likes FROM posts WHERE id = $postId");
                    $likeCountRow = mysqli_fetch_assoc($likeCountResult);
                    echo json_encode(['success' => true, 'liked' => false, 'likes' => $likeCountRow['likes']]);
                } else {
                    echo json_encode(['error' => 'Failed to update like count']);
                }
            }
        } else {
            // User has not liked this post, so we add the like
            if (!$isLike) {
                // User is attempting to unlike a post they haven't liked
                echo json_encode(['error' => 'You have not liked this post']);
                exit;
            }

            // Insert a new like
            $insertQuery = "INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)";
            if ($insertStmt = mysqli_prepare($conn, $insertQuery)) {
                mysqli_stmt_bind_param($insertStmt, 'ii', $postId, $userId);
                mysqli_stmt_execute($insertStmt);

                // Increase the likes count
                $updateQuery = "UPDATE posts SET likes = likes + 1 WHERE id = ?";
                if ($updateStmt = mysqli_prepare($conn, $updateQuery)) {
                    mysqli_stmt_bind_param($updateStmt, 'i', $postId);
                    mysqli_stmt_execute($updateStmt);

                    // Get updated likes count
                    $likeCountResult = mysqli_query($conn, "SELECT likes FROM posts WHERE id = $postId");
                    $likeCountRow = mysqli_fetch_assoc($likeCountResult);
                    echo json_encode(['success' => true, 'liked' => true, 'likes' => $likeCountRow['likes']]);
                } else {
                    echo json_encode(['error' => 'Failed to update like count']);
                }
            }
        }
    }
} else {
    echo json_encode(['error' => 'Post ID or User ID is missing']);
}
?>
