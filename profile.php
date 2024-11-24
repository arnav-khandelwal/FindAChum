<?php
session_start();
include 'db_connection.php'; // Replace with your database connection file

// Check if user is logged in
if (empty($_SESSION['user_name'])) {
    // If the user is not logged in, show the login/signup message
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>
        
        <!-- Load Bootstrap CSS first -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        
        <!-- Custom Styles -->
        <style>
            body.custom-dark-theme {
                background-color: #121212;
                color: #ffffff;
                margin: 0;
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
            }

            .custom-container {
                max-width: 500px;
                background-color: #1e1e1e;
                border: 2px solid #333;
                border-radius: 15px;
                padding: 30px;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            }

            .custom-heading {
                font-size: 2rem;
                font-weight: bold;
                margin-bottom: 20px;
            }

            .custom-text {
                font-size: 1.1rem;
                margin-bottom: 20px;
            }

            .custom-button {
                margin: 10px;
                padding: 10px 20px;
                font-size: 1rem;
                border-radius: 5px;
                transition: background-color 0.3s ease;
            }

            .custom-button-primary {
                background-color: #007bff;
                color: #fff;
                border: none;
            }

            .custom-button-primary:hover {
                background-color: #0056b3;
            }

            .custom-button-success {
                background-color: #28a745;
                color: #fff;
                border: none;
            }

            .custom-button-success:hover {
                background-color: #1e7e34;
            }
        </style>
    </head>
    <body class="custom-dark-theme">
    
    <!-- Navbar Placeholder -->
    <div id="navbar-placeholder"></div>

    <div class="custom-container">
        <h2 class="custom-heading">You are not logged in.</h2><br>
        <p class="custom-text">Please 
            <a href="signin.html" class="custom-button custom-button-primary" style = "text-decoration: none;">Log In</a> 
            or 
            <a href="signin.html" class="custom-button custom-button-success" style = "text-decoration: none;">Sign Up</a>
        </p>
    </div>

    <script>
        // Fetch the navbar content dynamically
        fetch("navbar.php")
            .then(response => response.text())
            .then(data => {
                document.getElementById("navbar-placeholder").innerHTML = data;
            })
            .catch(error => console.error("Error loading navbar:", error));
    </script>
    <script src="app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>';
    exit;
}

// Fetch current user info from the `user_info` table
$user_name = $_SESSION['user_name']; // Assuming `user_name` is stored in session after login
$query = "SELECT * FROM user_info WHERE user_name = '$user_name'";
$result = mysqli_query($conn, $query);
$user_data = mysqli_fetch_assoc($result);

if (!$user_data) {
    echo "User not found.";
    exit;
}

// Fetch posts from the `posts` table
$user_id = $_SESSION['user_id'];  // Assuming user_id exists in the user_info table
$posts_query = "SELECT * FROM posts WHERE user_id = '$user_id' ORDER BY date DESC";
$posts_result = mysqli_query($conn, $posts_query);
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
</script>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
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
        </div>

        <!-- Display Posts on the Right -->
        <div class="col-md-8">
            <h3>Posts by <?php echo htmlspecialchars($user_name); ?></h3>
            <?php if ($posts_result->num_rows > 0): ?>
                <div class="list-group">
                    <?php while ($post = $posts_result->fetch_assoc()): ?>
                        <div class="list-group-item mb-3"> <!-- Added mb-3 for spacing -->
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

<script src="app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
