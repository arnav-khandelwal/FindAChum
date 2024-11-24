<?php
session_start();
require 'db_connection.php'; // Replace with your actual DB connection script

// Check if a username is provided in the URL
if (!isset($_GET['username']) || empty($_GET['username'])) {
    echo "Invalid user profile.";
    exit;
}

$username = $_GET['username'];

// Fetch the user's data from the user_info table
$stmt = $conn->prepare("
    SELECT user_info.*, users.id AS user_id 
    FROM user_info 
    INNER JOIN users ON users.user_name = user_info.user_name 
    WHERE users.user_name = ?
");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "User profile not found.";
    exit;
}

$user_data = $result->fetch_assoc();
$user_id = $user_data['user_id']; // Get user ID for fetching posts

// Fetch the user's posts
$post_stmt = $conn->prepare("
    SELECT * 
    FROM posts 
    WHERE user_id = ? 
    ORDER BY date DESC
");
$post_stmt->bind_param("i", $user_id);
$post_stmt->execute();
$posts_result = $post_stmt->get_result();

// Check if the logged-in user is a friend of this profile user
// Check if the logged-in user is a friend of this profile user
$logged_in_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$friendship_status = null; // Default: no buttons if not logged in

if ($logged_in_user_id && $logged_in_user_id !== $user_id) {
    // Query to check if the logged-in user added this profile as a friend
    $friend_stmt = $conn->prepare("
        SELECT * FROM friends 
        WHERE user_id = ? AND friend_id = ?
    ");
    $friend_stmt->bind_param("ii", $logged_in_user_id, $user_id);
    $friend_stmt->execute();
    $friend_result = $friend_stmt->get_result();

    if ($friend_result->num_rows > 0) {
        // Logged-in user has added the profile being viewed as a friend
        $friendship_status = "friend"; // Already friends
        $button_action = "remove";
    } else {
        // Not friends yet
        $friendship_status = "not_friend"; // Not friends
        $button_action = "add";
    }

    $friend_stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user_data['user_name']); ?>'s Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<div id="navbar-placeholder"></div>

<script>
    document.getElementById("navbar-placeholder").innerHTML = fetch('navbar.php')
        .then(response => response.text())
        .then(data => document.getElementById('navbar-placeholder').innerHTML = data);
</script>

<div class="container mt-5">
    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-4">
            <h2><?php echo htmlspecialchars($user_data['user_name']); ?>'s Profile</h2>

            <!-- Display Profile Picture -->
            <div class="mb-3">
                <?php if (!empty($user_data['image_address'])): ?>
                    <img src="<?php echo htmlspecialchars($user_data['image_address']); ?>" alt="Profile Image" style="width:150px; height:150px; border-radius:50%;">
                <?php else: ?>
                    <img src="images/default_avatar.png" alt="Default Profile" style="width:150px; height:150px; border-radius:50%;">
                <?php endif; ?>
            </div>

            <!-- Display Profile Details -->
            <div>
                <p><strong>Bio:</strong> <?php echo htmlspecialchars($user_data['bio']); ?></p>
                <p><strong>Interests:</strong> <?php echo htmlspecialchars($user_data['interests']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($user_data['location']); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($user_data['age']); ?></p>
                <p><strong>Instagram:</strong> 
                    <?php if (!empty($user_data['instagram'])): ?>
                        <a href="https://instagram.com/<?php echo htmlspecialchars($user_data['instagram']); ?>" target="_blank">
                            <?php echo htmlspecialchars($user_data['instagram']); ?>
                        </a>
                    <?php else: ?>
                        Not provided
                    <?php endif; ?>
                </p>
                <p><strong>Twitter:</strong> 
                    <?php if (!empty($user_data['twitter'])): ?>
                        <a href="https://twitter.com/<?php echo htmlspecialchars($user_data['twitter']); ?>" target="_blank">
                            <?php echo htmlspecialchars($user_data['twitter']); ?>
                        </a>
                    <?php else: ?>
                        Not provided
                    <?php endif; ?>
                </p>
                <!-- Add Friend/Remove Friend Button -->
                <div class="container  mt-4">
                    <button class="btn btn-primary" id="friend-action-button" 
                    data-action="remove" 
                    data-username="<?php echo htmlspecialchars($user_data['user_name']); ?>">
                        Add Friend
                    </button>
                </div>
            </div>
        </div>

        <!-- User's Posts -->
        <div class="col-md-8">
            <h3>Posts by <?php echo htmlspecialchars($user_data['user_name']); ?></h3>
            <?php if ($posts_result->num_rows > 0): ?>
                <div class="list-group">
                    <?php while ($post = $posts_result->fetch_assoc()): ?>
                        <div class="list-group-item mb-3">
                            <h5><?php echo htmlspecialchars($post['title']); ?></h5>
                            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                            <small class="text-muted">Posted on <?php echo htmlspecialchars($post['date']); ?></small>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No posts yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", () => {
    const friendButton = document.getElementById("friend-action-button");

    if (friendButton) {
        friendButton.addEventListener("click", () => {
            const action = friendButton.dataset.action;
            const userName = friendButton.dataset.username; // The username of the profile being viewed

            if (action === "add") {
                addFriend(userName);
            } else if (action === "remove") {
                updateFriendStatus(userName, "remove");
            }
        });
    }
});

const FirstAction = "<?php echo $button_action; ?>"
updateButtonUI(FirstAction);

// Reuse your addFriend function for adding friends
function addFriend(userName) {
    fetch("add_friend.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ friend_user_name: userName }) // Send the friend's username
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Friend request sent successfully!");
                updateButtonUI("remove"); // Change button to 'Remove Friend'
            } else {
                alert("Failed to send friend request: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error adding friend:", error);
            alert("An error occurred while adding the friend.");
        });
}

// Function to handle removing a friend
function updateFriendStatus(userName, action) {
    fetch("update_friend_status.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ friend_user_name: userName, action: action }) // Send action and friend's username
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Friend removed successfully!");
                updateButtonUI("add"); // Change button to 'Add Friend'
            } else {
                alert("Failed to remove friend: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error updating friend status:", error);
            alert("An error occurred while updating the friend status.");
        });
}

// Function to update the button's UI dynamically
function updateButtonUI(newAction) {
    const friendButton = document.getElementById("friend-action-button");
    if (friendButton) {
        if (newAction === "add") {
            friendButton.dataset.action = "add";
            friendButton.textContent = "Add Friend";
        } else if (newAction === "remove") {
            friendButton.dataset.action = "remove";
            friendButton.textContent = "Remove Friend";
        }
    }
}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
