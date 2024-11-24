<?php
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link id="theme-stylesheet" rel="stylesheet" href="dark-theme.css">
    <style>
        /* Add padding to the top of the body to prevent content from being hidden behind the navbar */
        body {
            padding-top: 70px; /* Adjust the value depending on the height of your navbar */
        }

        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.75);
        }

        /* Light theme */
        .light-mode {
            background-color: white;
            color: black;
        }

        .light-mode .navbar-dark .navbar-nav .nav-link {
            color: rgba(0, 0, 0, 0.75);
        }

        /* Optional styling for the navbar */
        .fixed-top {
            z-index: 1030; /* Ensures the navbar stays above other content */
        }

        /* Styling for the search button inside the input field */
        form.d-flex {
            max-width: 300px; /* Set the width of the search bar */
        }

        form.d-flex input[type="search"] {
            padding-right: 2.5rem; /* Leave space for the search icon */
        }

        form.d-flex button {
            border: none;
            background: none;
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            padding: 0 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Optional: Styling for the search button icon */
        form.d-flex button i {
            font-size: 1rem;
            color: gray;
        }

        /* Add this CSS to style the profile image */
        .profile-img {
            width: 30px;
            height: 30px;
            object-fit: cover;  /* Ensures the image fits properly inside the circle */
        }


        /* Search bar on mobile view */
        @media (max-width: 767.98px) {
            form.d-flex {
                width: 100%;
            }
        }
        #searchInput::placeholder {
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SPORTS SOCIAL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="friends.php">Friends</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Mypage</a>
                    </li>
                </ul>
                <form class="d-flex ms-auto position-relative">
                    <input class="form-control me-2" id="searchInput" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-secondary position-absolute end-0" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <ul class="navbar-nav ms-2">
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- Profile Image with a small 30x30 circle -->
                        <img src="<?php echo isset($_SESSION['image_address']) ? $_SESSION['image_address'] : 'images/default_avatar.png'; ?>" class="profile-img rounded-circle" alt="Profile">
                    </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <?php if ($isLoggedIn): ?>
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="signin.html">Sign In / Sign Up</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="#">Check Past Posts</a></li>
                            <li class="dropdown-item">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="themeToggle">
                                    <label class="form-check-label" for="themeToggle">
                                        <i class="bi bi-brightness-high-fill"></i> / 
                                        <i class="bi bi-moon-fill"></i> Toggle Theme
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <script>
        // Load theme based on user preference
        const savedTheme = localStorage.getItem('theme') || 'light'; // Default to light if not set
        const themeStylesheet = document.getElementById('theme-stylesheet');
        
        // Set the href based on saved preference
        themeStylesheet.href = savedTheme === 'dark' ? 'dark-theme.css' : 'light-theme.css';

        // Toggle switch handling for theme change
        document.addEventListener("DOMContentLoaded", () => {
            const themeToggle = document.getElementById('themeToggle');
            themeToggle.checked = savedTheme === 'dark';

            themeToggle.addEventListener('change', function () {
                const newTheme = themeToggle.checked ? 'dark' : 'light';
                themeStylesheet.href = newTheme === 'dark' ? 'dark-theme.css' : 'light-theme.css';
                localStorage.setItem('theme', newTheme);
            });
        });
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>
