<?php
session_start();

// Database connection details
$host = 'localhost'; // Replace with your host
$db = 'findchums'; // Replace with your database name
$user = 'root'; // Replace with your database user
$pass = '123456'; // Replace with your database password

// Create a MySQLi connection
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration (signup)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        if ($stmt->errno == 1062) { // Duplicate entry error
            echo "Email is already registered.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}

// Handle login (signin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signin'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Retrieve user from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verify password and start session
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            echo "Login successful!";
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }
    $stmt->close();
}

$conn->close();
?>
