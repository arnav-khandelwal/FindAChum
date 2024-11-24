<?php
session_start();
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
        $stmtU = $conn->prepare("INSERT INTO user_info (user_name) VALUES (?)");
        $stmt->bind_param("ssss", $name, $user_name, $email, $hashed_password);
        $stmtU->bind_param("s",$user_name);
        $stmt->execute();
        $stmtU->execute();
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

    // Check if the user exists by email or username
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR user_name = ?");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_name'] = $user['user_name'];

            // Fetch image_address from the user_info table
            $user_name = $user['user_name'];
            $stmt2 = $conn->prepare("SELECT image_address FROM user_info WHERE user_name = ?");
            $stmt2->bind_param("s", $user_name);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($result2->num_rows > 0) {
                $user_info = $result2->fetch_assoc();
                $_SESSION['image_address'] = $user_info['image_address']; // Store image address in session
            }

            // Close second statement
            $stmt2->close();

            // Redirect to homepage or dashboard after successful login
            echo 'redirect';
            exit();
        } else {
            returnMessage("Invalid email or password.");
        }
    } else {
        returnMessage("Invalid email or password.");
    }

    // Close first statement
    $stmt->close();
}

$conn->close();
?>
