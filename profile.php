<?php
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : 'User Name';
$userBio = $isLoggedIn ? 'Bio: ' . $_SESSION['user_bio'] : 'Bio: Not available';
$userInterests = $isLoggedIn ? 'Sport Interests: ' . $_SESSION['user_interests'] : 'Sport Interests: Not available';
$userLocation = $isLoggedIn ? 'Location: ' . $_SESSION['user_location'] : 'Location: Not available';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Navbar -->
    <div id="navbar-placeholder"></div>
    <script>
        document.getElementById("navbar-placeholder").innerHTML = fetch('navbar.php')
            .then(response => response.text())
            .then(data => document.getElementById('navbar-placeholder').innerHTML = data);
    </script>

    <!-- Profile Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Profile Image" id="profileImage">
                    <div class="card-body">
                        <h5 class="card-title" id="userName"><?php echo htmlspecialchars($userName); ?></h5>
                        <p class="card-text" id="userBio"><?php echo htmlspecialchars($userBio); ?></p>
                        <p class="card-text" id="userInterests"><?php echo htmlspecialchars($userInterests); ?></p>
                        <p class="card-text" id="userLocation"><?php echo htmlspecialchars($userLocation); ?></p>
                        
                        <?php if ($isLoggedIn): ?>
                            <button class="btn btn-primary" id="editProfileBtn" onclick="toggleEditMode()">Edit Profile</button>
                        <?php else: ?>
                            <a href="signin.html" class="btn btn-success">Login</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Past Posts Section -->
            <div class="col-md-8">
                <?php if ($isLoggedIn): ?>
                    <button class="btn btn-success mt-3" onclick="openPostModal()" style="height: 40px; width: 150px;">Create New Post</button>
                <?php endif; ?>
                <br><br>
                <h3>Past Posts</h3>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Football:</strong> Played on Saturday at Central Park.
                    </li>
                    <li class="list-group-item">
                        <strong>Basketball:</strong> Game on Friday at Sports Complex.
                    </li>
                    <li class="list-group-item">
                        <strong>Tennis:</strong> Partner for doubles on Sunday.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Hidden Edit Form (Initially Hidden) -->
    <div class="container mt-3" id="editProfileForm" style="display: none;">
        <h3>Edit Profile</h3>
        <form>
            <div class="mb-3">
                <label for="editName" class="form-label">Name</label>
                <input type="text" class="form-control" id="editName" placeholder="Enter your name" value="<?php echo htmlspecialchars($userName); ?>">
            </div>
            <div class="mb-3">
                <label for="editBio" class="form-label">Bio</label>
                <textarea class="form-control" id="editBio" rows="2" placeholder="Enter your bio"><?php echo htmlspecialchars($userBio); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="editInterests" class="form-label">Sport Interests</label>
                <input type="text" class="form-control" id="editInterests" placeholder="Enter sports you are interested in" value="<?php echo htmlspecialchars($userInterests); ?>">
            </div>
            <div class="mb-3">
                <label for="editLocation" class="form-label">Location</label>
                <input type="text" class="form-control" id="editLocation" placeholder="Enter your location" value="<?php echo htmlspecialchars($userLocation); ?>">
            </div>
            <button type="button" class="btn btn-success" onclick="saveProfile()">Save Changes</button>
            <button type="button" class="btn btn-secondary" onclick="toggleEditMode()">Cancel</button>
        </form>
    </div>

    <!-- Create New Post Modal -->
    <div id="postModal" class="modal" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Post</h5>
                    <button type="button" class="btn-close" aria-label="Close" onclick="closePostModal()"></button>
                </div>
                <div class="modal-body">
                    <form id="newPostForm">
                        <div class="mb-3">
                            <label for="postTitle" class="form-label">Post Title</label>
                            <input type="text" class="form-control" id="postTitle">
                        </div>
                        <div class="mb-3">
                            <label for="postTags" class="form-label">Tags</label>
                            <input type="text" class="form-control" id="postTags">
                        </div>
                        <div class="mb-3">
                            <label for="postContent" class="form-label">Content</label>
                            <textarea class="form-control" id="postContent" rows="4"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="saveDraft()">Save Draft</button>
                        <button type="button" class="btn btn-success" onclick="submitPost()">Post</button>
                        <button type="button" class="btn btn-success" onclick="deleteDraft()">Delete draft</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="editProfile.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="app.js"></script>
</body>
</html>
