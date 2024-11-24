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

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .user-card {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .user-card img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }
        .user-card .username {
            flex-grow: 1;
            font-weight: bold;
            color: black;
        }
        .user-card button {
            margin-left: 10px;
        }
        .user-card .btn {
            padding: 6px 12px;
        }
        .container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .search-section {
            flex: 2; /* Takes about 70% of the screen */
        }
        .friends-section {
            flex: 1; /* Takes about 30% of the screen */
            border: 1px solid rgb(58, 4, 4);
            border-radius: 5px;
            padding: 15px;
            background-color: #0a0707;
        }
        #searchInput {
            width: 50%; /* Shortens the search box */
        }
        .list-group {
            background-color: #1a1a1a; /* Dark background for the entire list */
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Optional shadow for depth */
        }

        .list-group-item {
            background-color: #222; /* Dark background for list items */
            color: #fff; /* Light text for contrast */
            border: 1px solid #444; /* Subtle dark border */
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 8px; /* Space between list items */
            transition: background-color 0.3s ease; /* Smooth background transition on hover */
        }

        .list-group-item:hover {
            background-color: #333; /* Darker shade when hovered */
        }
        #searchInput::placeholder {
            color: white;
        }


    </style>
</head>
<body>

    <div id="navbar-placeholder"></div>

    <script>
        document.getElementById("navbar-placeholder").innerHTML = fetch('navbar.php')
            .then(response => response.text())
            .then(data => document.getElementById('navbar-placeholder').innerHTML = data);
        
        // Theme Management
        const savedTheme = localStorage.getItem('theme') || 'dark';
        const themeStylesheet = document.getElementById('theme-stylesheet');
        themeStylesheet.href = savedTheme === 'dark' ? 'dark-theme.css' : 'light-theme.css';

        function toggleTheme() {
            const currentTheme = localStorage.getItem('theme') || 'dark';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', newTheme);
            themeStylesheet.href = newTheme === 'dark' ? 'dark-theme.css' : 'light-theme.css';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const themeToggleBtn = document.getElementById('theme-toggle-btn');
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('change', toggleTheme);
            }
        });
    </script>

<div class="container mt-5">
    <!-- Search Section -->
    <div class="search-section">
        <h2>Friends</h2>
        
        <!-- Search for users -->
        <div class="input-group mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search for users">
            <div class="input-group-append">
                <button class="btn btn-primary" id="searchButton" onclick="searchUsers()">Search</button>
            </div>
        </div>
        
        <h3 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">Search Results</h3>
        <div id="searchResults">
            <!-- Search results will be shown here -->
        </div>
    </div>
    
    <div class="friends-section">
        <h3 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">Your Friends</h3>
        <ul id="friendsList" class="list-group">
            <!-- Friends list will be populated here -->
        </ul>
    </div>
</div>

<script>
// This function fetches the current user's friends and shows them
// This function fetches the current user's friends and shows them
function loadFriends() {
    fetch('get_friends.php')
    .then(response => response.json())
    .then(data => {
        const friendsList = document.getElementById('friendsList');
        friendsList.innerHTML = ''; // Clear previous results

        if (data.message) {
            // If there are no friends, display the message
            const noFriendsMessage = document.createElement('li');
            noFriendsMessage.classList.add('list-group-item');
            noFriendsMessage.textContent = data.message;
            friendsList.appendChild(noFriendsMessage);
        } else {
            // Otherwise, display the list of friends
            data.friends.forEach(friend => {
                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                listItem.innerHTML = `
                    <strong>${friend.user_name}</strong>
                    <button class="btn btn-danger btn-sm float-right" onclick="removeFriend(${friend.id})">Remove</button>
                `;
                friendsList.appendChild(listItem);
            });
        }
    });
}


// This function searches for users when the Search button is clicked
function searchUsers() {
    const query = document.getElementById('searchInput').value;
    if (query.trim() === "") {
        document.getElementById('searchResults').innerHTML = "";
        return;
    }

    fetch('search_users.php?query=' + query)
    .then(response => response.json())
    .then(data => {
        const searchResults = document.getElementById('searchResults');
        searchResults.innerHTML = ''; // Clear previous results

        data.users.forEach(user => {
            const userCard = document.createElement('div');
            userCard.classList.add('user-card');
            
            userCard.innerHTML = `
                <img src="${user.image_address}" alt="${user.user_name}">
                <span class="username">${user.user_name}</span>
                <button class="btn btn-primary btn-sm" onclick="viewProfile('${user.user_name}')">View Profile</button>
                ${user.isFriend ? 
                    `<button class="btn btn-secondary btn-sm" disabled>Friend</button>` :
                    `<button class="btn btn-success btn-sm" onclick="addFriend('${user.user_name}')">Add Friend</button>`
                }
            `;
            
            searchResults.appendChild(userCard);
        });
    });
}

// add a friend 
function addFriend(userName) {
    fetch('add_friend.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ friend_user_name: userName }) // Send the friend_user_name to the server
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Friend request sent successfully!");
            loadFriends(); // You may want to reload the friends list or update the UI
        } else {
            alert("Failed to send friend request: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error adding friend:", error);
        alert("An error occurred while adding the friend.");
    });
}



// Remove a friend
function removeFriend(friendId) {
    fetch('remove_friend.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ friend_id: friendId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Friend removed successfully!");
            loadFriends(); // Reload the friends list
        } else {
            alert("Failed to remove friend.");
        }
    });
}

// Redirect to the profile page of the user
function viewProfile(userName) {
    window.location.href = `user-profile.php?username=${userName}`;
}

// Initialize page by loading the user's friends
window.onload = loadFriends;
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
