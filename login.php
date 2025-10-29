<?php
include 'db_connect.php';

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Find user by email
$stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $name, $hashed_password);
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $hashed_password)) {
        // Password is correct!
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        
        // Redirect to dashboard
        header("Location: ../dashboard.html");
    } else {
        // Invalid password
        echo "<script>alert('Invalid email or password.'); window.location.href = '../index.html';</script>";
    }
} else {
    // No user found
    echo "<script>alert('Invalid email or password.'); window.location.href = '../index.html';</script>";
}

$stmt->close();
$conn->close();
?>