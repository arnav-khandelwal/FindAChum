<?php
session_start();
include 'db_connection.php'; // Replace with your database connection file

// Fetch current user info from the `user_info` table
$user_name = $_SESSION['user_name']; // Assuming `user_name` is stored in session after login
$query = "SELECT * FROM user_info WHERE user_name = '$user_name'";
$result = mysqli_query($conn, $query);
$user_data = mysqli_fetch_assoc($result);

if (!$user_data) {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<div id="navbar-placeholder"></div>

<script>
    document.getElementById("navbar-placeholder").innerHTML = fetch('navbar.php')
        .then(response => response.text())
        .then(data => document.getElementById('navbar-placeholder').innerHTML = data);
        const savedTheme = localStorage.getItem('theme') || 'dark';
        const themeStylesheet = document.getElementById('theme-stylesheet');
        themeStylesheet.href = savedTheme === 'dark' ? 'dark-theme.css' : 'light-theme.css';

        function toggleTheme() {
        // Retrieve the current theme again to ensure it toggles correctly
        const currentTheme = localStorage.getItem('theme') || 'dark';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('theme', newTheme);
        themeStylesheet.href = newTheme === 'dark' ? 'dark-theme.css' : 'light-theme.css';
        }

        // Assuming there is a button with id 'theme-toggle-btn' to toggle theme
        document.getElementById('theme-toggle-btn').addEventListener('change', toggleTheme);

</script>

<div class="container mt-5">
    <h2><?php echo htmlspecialchars($user_name); ?>'s Profile</h2>

    <!-- Display Profile Picture -->
    <div class="mb-3">
        <?php if (!empty($user_data['image_address'])): ?>
            <img src="<?php echo htmlspecialchars($user_data['image_address']); ?>" alt="Profile Image" style="width:150px; height:150px; border-radius:50%;">
        <?php else: ?>
            <img src="images\default_avatar.png" alt="Default Profile" style="width:150px; height:150px; border-radius:50%;">
        <?php endif; ?>
    </div>

    <!-- Display and Edit Profile Fields -->
    <div id="profileDisplay">
        <p><strong>Bio:</strong> <?php echo htmlspecialchars($user_data['bio']); ?></p>
        <p><strong>Interests:</strong> <?php echo htmlspecialchars($user_data['interests']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($user_data['location']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($user_data['age']); ?></p>
        <p><strong>Instagram:</strong> <?php echo htmlspecialchars($user_data['instagram']); ?></p>
        <p><strong>Twitter:</strong> <?php echo htmlspecialchars($user_data['twitter']); ?></p>
        <button class="btn btn-primary" onclick="toggleEditMode()">Edit Profile</button>
    </div>

    <!-- Edit Profile Form -->
    <div id="editProfileForm" style="display:none;">
        <h3>Edit Profile</h3>
        <form id="editProfileFields">
            <div class="mb-3">
                <label for="editBio" class="form-label">Bio</label>
                <textarea class="form-control" id="editBio" placeholder="Update your bio"><?php echo htmlspecialchars($user_data['bio']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="editInterests" class="form-label">Interests</label>
                <input type="text" class="form-control" id="editInterests" placeholder="Sports interests" value="<?php echo htmlspecialchars($user_data['interests']); ?>">
            </div>
            <div class="mb-3">
                <label for="editLocation" class="form-label">Location</label>
                <input type="text" class="form-control" id="editLocation" placeholder="City or area" value="<?php echo htmlspecialchars($user_data['location']); ?>">
            </div>
            <div class="mb-3">
                <label for="editAge" class="form-label">Age</label>
                <input type="number" class="form-control" id="editAge" placeholder="Enter your age" value="<?php echo htmlspecialchars($user_data['age']); ?>">
            </div>
            <div class="mb-3">
                <label for="editInstagram" class="form-label">Instagram</label>
                <input type="text" class="form-control" id="editInstagram" placeholder="Instagram username" value="<?php echo htmlspecialchars($user_data['instagram']); ?>">
            </div>
            <div class="mb-3">
                <label for="editTwitter" class="form-label">Twitter</label>
                <input type="text" class="form-control" id="editTwitter" placeholder="Twitter username" value="<?php echo htmlspecialchars($user_data['twitter']); ?>">
            </div>
            <button type="button" class="btn btn-success" onclick="saveProfile()">Save Changes</button>
            <button type="button" class="btn btn-secondary" onclick="toggleEditMode()">Cancel</button>
        </form>
    </div>
</div>

<script>
// Toggle between profile display and edit mode
function toggleEditMode() {
    document.getElementById("profileDisplay").style.display =
        document.getElementById("profileDisplay").style.display === "none" ? "block" : "none";
    document.getElementById("editProfileForm").style.display =
        document.getElementById("editProfileForm").style.display === "none" ? "block" : "none";
}

// Save Profile changes
function saveProfile() {
    const fields = {
        bio: document.getElementById('editBio').value.trim(),
        interests: document.getElementById('editInterests').value.trim(),
        location: document.getElementById('editLocation').value.trim(),
        age: document.getElementById('editAge').value.trim(),
        instagram: document.getElementById('editInstagram').value.trim(),
        twitter: document.getElementById('editTwitter').value.trim(),
    };

    fetch('save_profile.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(fields),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload profile to show updated info
        } else {
            alert("Failed to update profile.");
        }
    });
}
</script>

</body>
</html>
