<?php
session_start();

// Database connection details
$host = 'localhost';
$db = 'findchums';
$user = 'root';
$pass = '123456';

$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function returnMessage($message) {
    echo $message;
}

// Handle registration (signup)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $user_name = $conn->real_escape_string($_POST['user_name']); // Capture username
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        returnMessage("Passwords do not match.");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Prepare statement to insert user information
        $stmt = $conn->prepare("INSERT INTO users (name, user_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $user_name, $email, $hashed_password);
        $stmt->execute();
        returnMessage("Registration successful! Please login");
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // Duplicate entry error code
            returnMessage("Email or Username is already registered.");
        } else {
            returnMessage("Error: " . $e->getMessage());
        }
    }
}

// Handle login (signin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signin'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR user_name = ?"); // Check by email or username
    $stmt->bind_param("ss", $email, $email); // Binding email as both email and username for query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['user_bio'] = "bio"; // Assuming 'bio' column exists in your users table
            $_SESSION['user_interests'] = "interests"; // Assuming 'interests' column exists
            $_SESSION['user_location'] = "location"; // Assuming 'location' column exists

            // Redirect to homepage after successful login
            echo 'redirect';
            exit(); // Always exit after outputting the script
        } else {
            returnMessage("Invalid email or password.");
        }
    } else {
        returnMessage("Invalid email or password.");
    }
    $stmt->close();
}

$conn->close();
?>
