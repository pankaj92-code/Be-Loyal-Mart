<?php
include 'db_connect.php';

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Basic validation
if (empty($name) || empty($email) || empty($password)) {
    die("Please fill all required fields.");
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('Error: This email is already registered.'); window.location.href = '../index.html';</script>";
} else {
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, points) VALUES (?, ?, ?, 200)"); // 200 Welcome Points
    $stmt->bind_param("ssi", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        // Automatically log in the user
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_name'] = $name;
        
        // Redirect to dashboard
        header("Location: ../dashboard.html");
    } else {
        echo "<script>alert('Error: Could not register. Please try again.'); window.location.href = '../index.html';</script>";
    }
}

$stmt->close();
$conn->close();
?>